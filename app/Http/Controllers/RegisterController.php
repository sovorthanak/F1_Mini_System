<?php

namespace App\Http\Controllers;

use App\Models\Bandwidth;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\Tariffs;
use App\Models\Register; // Ensure this model exists in the specified namespace
use App\Models\Tariff;
use App\Models\IpAddress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\IpPool;
use App\Models\IpChild;
use App\Models\IpInventory;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    // public function index()
    // {
    //     // Fetch all tariffs from the model
    //     // Pass the data to the view
    //     $tariffs = Tariff::where('status', 1)->pluck('name');
    //     $locations = Location::where('status', true)->get(); // Only active ones
    //     $bandwidths = Bandwidth::where('status', 1)
    //                 ->orderByRaw("CAST(REPLACE(speed, 'Mbps', '') AS UNSIGNED) ASC")
    //                 ->get();
        
    //     return view('register.index', compact('tariffs', 'locations', 'bandwidths'));
    // }
    public function index()
    {
        // Existing
        $tariffs = Tariff::where('status', 1)->pluck('name');

        $locations = Location::where('status', true)->get();

        $bandwidths = Bandwidth::where('status', 1)
            ->orderByRaw("CAST(REPLACE(speed, 'Mbps', '') AS UNSIGNED) ASC")
            ->get();

        $pools = IpPool::where("is_active", true)->orderBy("name")->get();

        $freeInventory = IpInventory::where('status', "free")->get();

        $poolsInventory = IpInventory::with('pool')->get();

        $freeByPool = $freeInventory->groupBy('ip_pool_id')->map(function ($items) {
            return $items->map(fn($i) => ['id' => $i->id, 'ip' => $i->ip_address])->values();
        });

        return view('register.index', compact(
            'tariffs',
            'locations',
            'bandwidths',
            'pools',
            'freeByPool'
        ));
    }


    
    public function show($id)
    {
        $customer = Register::find($id); // Adjust based on your model
        if ($customer) {
            return response()->json([
                'success' => true,
                'customer' => [
                    'name' => $customer->customer_name,
                    'status' => $customer->status,
                    'old_tariff' => $customer->tariff_name,
                    'old_bandwidth' => $customer->bandwidth,
                    
                    'old_address' => $customer->address_line_1,
                    'old_alt_address' => $customer->alt_address_line_1,
                    'old_ip_addresses' => $customer->ipInventory
                        ->map(fn($inv) => ['id' => $inv->id, 'ip_address' => $inv->ip_address])
                        ->values()->toArray(),
                    
                    'old_location' => $customer->province,
                    'old_pppoe' => $customer->pppoe,
                    'old_password' => $customer->password,
                    'old_router' => $customer->router,
                ],
            ]);
        } else {
            return response()->json([
                'success' => false,
            ], 404);
        }
    }

    public function queryActiveIp()
    {
        $data = IpAddress::whereHas('customer', function ($q) {
                $q->where('status', 'Active');
            })
            ->with(['customer:customer_id,customer_id'])
            ->get(['customer_id', 'ip_address'])
            ->groupBy('customer.customer_id')
            ->map(function ($items) {
                return $items->pluck('ip_address');
            });

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function storeRegister(Request $request)
    {
        // 1) Validate customer fields + ip_items
        $validated = $request->validate([
            // Customer primary key
            'customer_id' => 'required|string|max:100|unique:customers_info,customer_id',
            // ID upload (maps to identity_doc)
            'id_or_passport_image' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:5120',
            // IP items: at least 1
            'ip_items'        => 'required|array|min:1',
            'ip_items.*.id'   => 'required|integer|',
            'ip_items.*.note' => 'nullable|string|max:255',
        ]);

        // Normalize ip_items -> array of {id, note}
        $ipItems = collect($validated['ip_items'])
            ->map(fn ($item) => [
                'id'   => (int) $item['id'],
                'note' => isset($item['note']) ? trim((string) $item['note']) : null,
            ])
            ->values();

        try {
            DB::transaction(function () use ($request, $validated, $ipItems) {
                // 3) Create customer in customers_info using Register model
                //    (boot() will fill created_by + dates logic)
                $customer = Register::create([
                    'customer_id'       => $validated['customer_id'],
                    'customer_name' => $request->customer_name,
                    'phone_number'  => $request->phone_number,
                    'identity_doc'  => $request->identity_doc,
                    'pppoe'         => $request->pppoe,
                    'passport'      => $request->passport,
                    'router'       => $request->router,
                    'province'     => $request->province,
                    'address_line_1' => $request->address_line_1, 
                    'currency'      => $request->currency,
                    'first_start_date' => $request->start_date,
                    'start_date'    => $request->start_date,
                    'internet_fee'  => $request->internet_fee,
                    'ip_fee'        => $request->ip_fee,
                    'ip_quantity'   => $ipItems->count(),
                    'bill_cycle'    => $request->bill_cycle,
                    'alt_customer_name' => $request->alt_customer_name,
                    'lat_long'      => $request->lat_long,
                    'alt_address_line_1' => $request->alt_address_line_1, 
                    'agent'         => $request->agent,
                    'tariff_name'   => $request->tariff_name,
                    'bandwidth'     => $request->bandwidth,
                    'installation_fee' => $request->installation_fee,
                    'complete_date'  => $request->complete_date,
                    'remark'       => $request->remark,
                    'status'            => 'Active', // change if you want
                ]);

                // 4) Lock inventories to prevent double-assign (race condition)
                $inventories = IpInventory::whereIn('id', $ipItems->pluck('id'))
                    ->lockForUpdate()
                    ->get();

                // 5) Assign each selected IP to this customer_id, store note
                foreach ($inventories as $inv) {
                    $note = $ipItems->firstWhere('id', $inv->id)['note'] ?? null;
                    $inv->update([
                        'customer_id' => $customer->customer_id,
                        'status'      => 'assigned',
                        'note'        => $note,
                    ]);
                }
            });
            return redirect()
                ->route('register')
                ->with('success', 'Customer created and IPs assigned successfully.');
        } catch (ValidationException $e) {
            throw $e;
        }

        // return response()->json($request->all());
    }

}