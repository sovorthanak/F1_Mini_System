<?php

namespace App\Http\Controllers;

use App\Imports\CustomerImport;
use App\Models\Location;
use App\Models\Register;
use App\Models\Tariff;
use App\Models\Tariffs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Bandwidth;
use Carbon\Carbon;

class CustomersController extends Controller
{
    //
    public function index()
    {
        // Fetch all customers with their tariffs
        $customers = Register::get();
        $totalCustomers = Register::count();
        $activeCustomers = Register::where('status', 'Active')->count();
        $locations = Location::where('status', 1)->get();
        $tariffs = Tariff::where('status', '1')->get(); 

        return view('customers.index', compact('customers', 'totalCustomers', 'activeCustomers', 'locations', 'tariffs'));
    }

    public function TSCustomers()
    {
        // Fetch all customers with their tariffs for NOC view
        $customers = Register::get();
        $totalCustomers = Register::count();
        $activeCustomers = Register::where('status', 'Active')->count();
        $locations = Location::where('status', 1)->get();
        $tariffs = Tariff::where('status', '1')->get(); 

        return view('customers.ts_customers', compact('customers', 'totalCustomers', 'activeCustomers', 'locations', 'tariffs'));
    }   

    public function viewDetails($customer_id) {
        $customer = Register::with('ipInventory')
                    ->where('customer_id', $customer_id)
                    ->firstOrFail();
        // return response()->json($customer);
        return view('customers.view-details', compact('customer'));
    }

    public function editDetails($customer_id){
        
        $customer = Register::where('customer_id', $customer_id)->firstOrFail();
        $locations = Location::where('status', 1)->get();
        $tariffs = Tariff::where('status', 1)->pluck('name');
        $bandwidths = Bandwidth::where('status', 1)
            ->orderByRaw("CAST(REPLACE(speed, 'Mbps', '') AS UNSIGNED) ASC")
            ->get();

        return view('customers.edit-details', compact('customer', 'locations', 'tariffs', 'bandwidths'));
    }


    public function updateDetails(Request $request, $customer_id) {

        $customer = Register::findOrFail($customer_id);
        
        $request->validate([
            'id_or_passport_image' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        
        // If new file is uploaded
        if ($request->hasFile('id_or_passport_image')) {
            $file = $request->file('id_or_passport_image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('id_cards', $fileName, 'public');
    
            // Optional: delete old file
            if ($customer->identity_doc && Storage::disk('public')->exists('id_cards/' . $customer->identity_doc)) {
                Storage::disk('public')->delete('id_cards/' . $customer->identity_doc);
            }
    
            $customer->identity_doc = $fileName;
        }
    
        // Only update fields that are editable
        $customer->customer_name = $request->input('customer_name');
        $customer->phone_number = $request->input('phone_number');
        $customer->pppoe = $request->input('pppoe');
        $customer->password = $request->input('password');
        $customer->address_line_1 = $request->input('address_line_1');
        $customer->currency = $request->input('currency');
        $customer->province = $request->input('province');

        // ❌ REMOVE these lines to prevent null overwriting
        // $customer->first_start_date = $request->input('start_date');
        // $customer->start_date = $request->input('start_date');
    
        $customer->internet_fee = $request->input('internet_fee');
        $customer->bill_cycle = $request->input('bill_cycle');
        $customer->alt_customer_name = $request->input('alt_customer_name');
        $customer->lat_long = $request->input('lat_long');
        $customer->alt_address_line_1 = $request->input('alt_address_line_1');
        $customer->agent = $request->input('agent');
        $customer->tariff_name = $request->input('tariff_name');
        $customer->bandwidth = $request->input('bandwidth');
        $customer->router = $request->input('router');
        $customer->remark = $request->input('remark');
    
        $customer->last_updated = now();
        $customer->updated_by = Auth::user()->name;
        $customer->created_by = $customer->created_by ?? Auth::user()->name;
        $customer->update_attempts = ($customer->update_attempts ?? 0) + 1;
    
        $customer->save();
    
        return redirect()->back()->with('success', 'Customer details updated successfully!');
    }

    public function destroy($customer_id){
        
        $customer = Register::findOrFail($customer_id);
        $customer->delete();

        return redirect()->back()->with('delete-success', 'Customer deleted successfully.');
    }

    public function userAgreement($id) {
        $customer = Register::findOrFail($id);
        
        // Assuming you have a method to generate the user agreement
        // This could be a view or a PDF generation logic
        return view('customers.user-agreement', compact('customer'));
    }


    public function getCustomers(Request $request)
    {
        $customers = Register::query();

        // Filters
        if (!empty($request->min_date)) {
            $customers->whereDate('created_at', '>=', $request->min_date);
        }

        if (!empty($request->max_date)) {
            $customers->whereDate('created_at', '<=', $request->max_date);
        }

        if (!empty($request->location)) {
            $customers->where('province', $request->location);
        }

        if (!empty($request->status)) {
            $customers->where('status', $request->status);
        }

        // ✅ Tariff filter (by name)
        $tariffName = $request->input('tariff');
        if (!empty($tariffName)) {
            $customers->where('tariff_name', $tariffName);
        }
        
        $colIndex = $request->input('column_index');
        $colValue = $request->input('column_search');
    
        $map = [
            '0' => 'customer_id',
            '1' => 'customer_name',
            '2' => 'pppoe',
            '3' => 'router',
            '4' => 'remark',
            '5' => 'province',
            '6' => 'tariff_name', // or join/concat logic if needed
            '7' => 'agent',
            '9' => 'status',
        ];
        
        if ($colValue !== null && $colValue !== '' && isset($map[(string)$colIndex])) {
            $column = $map[(string)$colIndex];
            $customers->where($column, 'like', '%' . $colValue . '%');
        }

        // Count active within current filtered set
        $activeCount = (clone $customers)->where('status', 'Active')->count();

        // ✅ Order newest → oldest
        $customers->orderBy('created_at', 'desc');  

        return DataTables::of($customers)
            ->filterColumn('tariff_bandwidth', function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('tariff_name', 'like', "%{$keyword}%")
                    ->orWhere('bandwidth', 'like', "%{$keyword}%");
                });
            })
            ->addColumn('tariff_bandwidth', function ($row) {
                return trim(($row->tariff_name ?? '') . ' ' . ($row->bandwidth ?? ''));
            })
            ->addColumn('created_by_name', function ($row) {
                return optional($row->creator)->name ?? '---';
            })
            ->with('activeCount', $activeCount)
            ->make(true);
    }

    public function downloadExcel(Request $request)
    {
        $q = Register::query();

        // ---------------------------------------------------------
        // 1) Normalize params (support BOTH table + download page)
        // ---------------------------------------------------------
        $province   = $request->input('province') ?? $request->input('location');   // table uses location
        $tariffName = $request->input('tariff_name') ?? $request->input('tariff'); // chart/table uses tariff
        $status     = $request->input('status');
        $billCycle  = $request->input('bill_cycle');

        $minDate    = $request->input('min_date');
        $maxDate    = $request->input('max_date');

        // ✅ DataTables global search ALWAYS use search.value (string)
        $globalSearch = trim((string) $request->input('search.value', ''));
        
        $colIndex = $request->input('column_index');
        $colValue = $request->input('column_search');
        
        $map = [
            '0' => 'customer_id',
            '1' => 'customer_name',
            '2' => 'pppoe',
            '3' => 'router',
            '4' => 'remark',
            '5' => 'province',
            '6' => 'tariff_name', // adjust if your DB column differs
            '7' => 'agent',
            '9' => 'status',
        ];
        
        if ($colValue !== null && $colValue !== '' && isset($map[(string)$colIndex])) {
            $column = $map[(string)$colIndex];
            $q->where($column, 'like', '%' . $colValue . '%');
        }


        // ---------------------------------------------------------
        // 2) Apply filters
        // ---------------------------------------------------------
        if (!empty($province)) {
            $q->where('province', $province);
        }

        if (!empty($tariffName)) {
            $q->where('tariff_name', $tariffName);
        }

        if (!empty($billCycle)) {
            $bill = (string) $billCycle;
            $billNum = (int) preg_replace('/\D+/', '', $bill);

            $q->where(function ($sub) use ($bill, $billNum) {
                $sub->where('bill_cycle', $bill)
                    ->orWhere('bill_cycle', $billNum)
                    ->orWhere('bill_cycle', (string) $billNum);
            });
        }

        if (!empty($status)) {
            $q->where('status', $status);
        }

        if (!empty($minDate)) {
            $q->whereDate('created_at', '>=', $minDate);
        }
        if (!empty($maxDate)) {
            $q->whereDate('created_at', '<=', $maxDate);
        }

        // ---------------------------------------------------------
        // 3) Column search (your download page "Search By")
        // ---------------------------------------------------------
        $colIndex = $request->input('column_index');
        $keyword  = trim((string) $request->input('column_search', ''));

        if ($keyword !== '' && $colIndex !== null && $colIndex !== '') {
            $idx = (int) $colIndex;

            if ($idx === 0) {
                $q->where('customer_id', 'like', "%{$keyword}%");
            } elseif ($idx === 1) {
                $q->where('customer_name', 'like', "%{$keyword}%");
            } elseif ($idx === 2) {
                $q->where('pppoe', 'like', "%{$keyword}%");
            } elseif ($idx === 3) {
                $q->where('province', 'like', "%{$keyword}%");
            } elseif ($idx === 4) {
                $q->where(function ($sub) use ($keyword) {
                    $sub->where('tariff_name', 'like', "%{$keyword}%")
                        ->orWhere('bandwidth', 'like', "%{$keyword}%");
                });
            } elseif ($idx === 19) {
                // registered at = created_at
                $q->whereDate('created_at', $keyword);
            }
        }

        // ---------------------------------------------------------
        // 4) Global search (DataTables search box)
        //    Only apply when column_search is NOT used
        // ---------------------------------------------------------
        if ($globalSearch !== '' && $keyword === '') {
            $q->where(function ($sub) use ($globalSearch) {
                $sub->where('customer_id', 'like', "%{$globalSearch}%")
                    ->orWhere('customer_name', 'like', "%{$globalSearch}%")
                    ->orWhere('pppoe', 'like', "%{$globalSearch}%")
                    ->orWhere('province', 'like', "%{$globalSearch}%")
                    ->orWhere('tariff_name', 'like', "%{$globalSearch}%")
                    ->orWhere('phone_number', 'like', "%{$globalSearch}%");
            });
        }

        // ---------------------------------------------------------
        // 5) Ordering (DataTables sends order[0][column], order[0][dir])
        // ---------------------------------------------------------
        $orderCol = (int) $request->input('order.0.column', $request->input('order_col', 19));
        $orderDir = strtolower((string) $request->input('order.0.dir', $request->input('order_dir', 'desc')));
        if (!in_array($orderDir, ['asc', 'desc'], true)) $orderDir = 'desc';

        // Map visible table column index -> DB column
        // IMPORTANT: match your DataTable columns indexes
        $columns = [
            0 => 'customer_id',
            1 => 'customer_name',
            2 => 'pppoe',
            5 => 'province',
            8 => 'created_at',
            9 => 'status',
            // For your "tariff_bandwidth" column (index 6), sort by tariff_name
            6 => 'tariff_name',
        ];

        $sortCol = $columns[$orderCol] ?? 'created_at';
        $q->orderBy($sortCol, $orderDir);

        // ---------------------------------------------------------
        // 6) Get data
        // ---------------------------------------------------------
        $customers = $q->get([
            'customer_id',
            'customer_name',
            'pppoe',
            'province',
            'tariff_name',
            'bandwidth',
            'bill_cycle',
            'first_start_date',
            'internet_fee',
            'installation_fee',
            'ip_fee',
            'start_date',
            'phone_number',
            'address_line_1',
            'alt_address_line_1',
            'currency',
            'lat_long',
            'agent',
            'created_by',
            'created_at',
            'status',
            // 'ip_address', // include only if this column exists in Register table
        ]);

        // ---------------------------------------------------------
        // 7) Excel output (HTML table as .xls)
        // ---------------------------------------------------------
        $filename = 'Customer_List_' . now()->format('Ymd_His') . '.xls';

        $headers = [
            "Content-Type" => "application/vnd.ms-excel; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Cache-Control" => "no-cache, no-store, must-revalidate",
            "Pragma" => "no-cache",
            "Expires" => "0",
        ];

        $fmtDate = function ($value) {
            if (empty($value) || $value === 'N/A') return 'N/A';
            try { return Carbon::parse($value)->format('d F, Y'); }
            catch (\Throwable $e) { return 'N/A'; }
        };

        $fmtMoney = function ($value) {
            if ($value === null || $value === '' || $value === 'N/A') return 'N/A';
            if (!is_numeric($value)) return (string) $value;
            return '$' . number_format((float) $value, 2);
        };

        $html = '<table border="1">';
        $html .= '<tr>
            <th>ID</th>
            <th>Customer Name</th>
            <th>PPPOE</th>
            <th>Location</th>
            <th>Tariff</th>
            <th>Bill Cycle</th>
            <th>Start Date</th>
            <th>Internet Fee</th>
            <th>Installation Fee</th>
            <th>IP Fee</th>
            <th>Next Issue Date</th>
            <th>Phone Number</th>
            <th>IP Address</th>
            <th>Address</th>
            <th>Address (Khmer)</th>
            <th>Currency</th>
            <th>Lat Long</th>
            <th>Agent</th>
            <th>Created By</th>
            <th>Registered At</th>
            <th>Status</th>
        </tr>';

        foreach ($customers as $c) {
            $tariff = trim(($c->tariff_name ?? '---') . ' ' . ($c->bandwidth ?? '---'));

            $bill = $c->bill_cycle ?? 'N/A';
            if (is_numeric($bill)) $bill = $bill . ' Month(s)';

            $html .= '<tr style="height:25px;">'
                . '<td>' . e($c->customer_id) . '</td>'
                . '<td>' . e($c->customer_name) . '</td>'
                . '<td>' . e($c->pppoe ?? '---') . '</td>'
                . '<td>' . e($c->province ?? '---') . '</td>'
                . '<td>' . e($tariff) . '</td>'
                . '<td>' . e($bill) . '</td>'
                . '<td>' . e($fmtDate($c->first_start_date)) . '</td>'
                . '<td>' . e($fmtMoney($c->internet_fee)) . '</td>'
                . '<td>' . e($c->installation_fee ?? 'N/A') . '</td>'
                . '<td>' . e($c->ip_fee ?? 'N/A') . '</td>'
                . '<td>' . e($fmtDate($c->start_date)) . '</td>'
                . '<td>' . e($c->phone_number ?? 'N/A') . '</td>'
                . '<td>' . e($c->ip_address ?? 'N/A') . '</td>'  // if not present, will be null => N/A
                . '<td>' . e($c->address_line_1 ?? 'N/A') . '</td>'
                . '<td>' . e($c->alt_address_line_1 ?? 'N/A') . '</td>'
                . '<td>' . e($c->currency ?? 'N/A') . '</td>'
                . '<td>' . e($c->lat_long ?? 'N/A') . '</td>'
                . '<td>' . e($c->agent ?? 'N/A') . '</td>'
                . '<td>' . e($c->created_by ?? 'N/A') . '</td>'
                . '<td>' . e($fmtDate($c->created_at)) . '</td>'
                . '<td>' . e($c->status ?? 'Active') . '</td>'
                . '</tr>';
        }

        $html .= '</table>';

        return response($html, 200, $headers);
    }

    public function getTSCustomerData(Request $request)
    {
        $user = Auth::user();

        $customers = Register::query();

        // Get all roles of the user
        $roles = $user->roles->pluck('name');

        // Filter roles that start with 'TS ' and are **province roles**
        $provinceRoles = $roles->filter(function ($role) {
            // Exclude non-province TS roles like 'TS Team Leader' if needed
            return str_starts_with($role, 'TS ') && $role !== 'TS Team Leader';
        });

        // ----------------------------------------
        // Role-based Filtering
        // ----------------------------------------
        // Apply province filter if any
        if ($provinceRoles->isNotEmpty()) {
            // Get province names from role, e.g. 'TS Kampot' => 'Kampot'
            $provinces = $provinceRoles->map(fn($r) => substr($r, 3))->toArray();

            // Filter customers whose province is in the user's TS provinces
            $customers->whereIn('province', $provinces);
        }

        // Filter: min date
        if ($request->filled('min_date')) {
            $customers->whereDate('created_at', '>=', $request->min_date);
        }

        // Filter: max date
        if ($request->filled('max_date')) {
            $customers->whereDate('created_at', '<=', $request->max_date);
        }

        // Filter: status
        if ($request->filled('status')) {
            $customers->where('status', $request->status);
        }

        // ----------------------------------------
        // Count after filters
        // ----------------------------------------
        $totalCount = (clone $customers)->count();

        $activeCount = (clone $customers)
            ->where('status', 'Active')
            ->count();

        // ----------------------------------------
        // DataTables Response
        // ----------------------------------------
        return DataTables::of($customers)
            ->filterColumn('tariff_bandwidth', function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('tariff_name', 'like', "%{$keyword}%")
                    ->orWhere('bandwidth', 'like', "%{$keyword}%");
                });
            })
            ->addColumn('tariff_bandwidth', function ($row) {
                return ($row->tariff_name ?? '---') . ' ' . ($row->bandwidth ?? '---');
            })
            ->addColumn('created_by', function ($row) {
                return $row->creator ? $row->creator->name : '---';
            })
            ->addColumn('action', function ($row) {
                return '
                    <a href="/customers/'.$row->customer_id.'/view-details"
                    class="btn btn-primary" style="padding: 0.1rem 0.2rem; font-size: 0.75rem;">
                    <i class="fas fa-eye"></i></a>

                    <a href="/customers/'.$row->customer_id.'/edit-details"
                    class="btn btn-success" style="padding: 0.1rem 0.2rem; font-size: 0.75rem;">
                    <i class="fas fa-edit"></i></a>
                ';
            })
            ->with([
                'total_count' => $totalCount,
                'active_count' => $activeCount,
            ])
            ->rawColumns(['action'])
            ->make(true);
    }


    public function downloadCustomerData(Request $request)
    {
        // Fetch only active provinces and tariffs
        $locations = Location::where('status', 1)->get();
        $tariffs = Tariff::where('status', '1')->get(); 

        // Fetch all customers
        $customers = Register::get();

        // Pass data to the view
        return view('customers.download-customer-datas', compact('customers', 'locations', 'tariffs'));
    }

}
