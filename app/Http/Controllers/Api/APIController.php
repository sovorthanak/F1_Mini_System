<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Register;
use App\Models\RequestChange;
use Carbon\Carbon;
// use Symfony\Component\HttpFoundation\Request;
use Yajra\DataTables\DataTables;
use App\Models\CaseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\IpAddress;
use App\Models\RequestTesting;

class APIController extends Controller
{
    public function getCustomerData()
    {
        // Fetch customers directly from the Register table
        $customers = Register::get(['customer_name', 'tariff_name', 'bandwidth', 'internet_fee']);

        // Format response
        $data = $customers->map(function($customer) {
            return [
                'customer_name' => $customer->customer_name,
                'tariff_name'   => $customer->tariff_name,
                'bandwidth'     => $customer->bandwidth,
                'internet_fee'  => $customer->internet_fee,
            ];
        });

        return response()->json($data);
    }


    public function getAllRequestChangeData(Request $request)
    {
        $query = RequestChange::with('customer');
    
        // Total records before filtering
        $totalRecords = $query->count();
    
        /*
        |--------------------------------------------------------------------------
        | GLOBAL SEARCH (DataTables default search box)
        |--------------------------------------------------------------------------
        */
        if ($search = $request->input('search.value')) {
    
            $query->where(function ($q) use ($search) {
                $q->where('request_type', 'like', "%{$search}%")
                  ->orWhere('old_customer_name', 'like', "%{$search}%")
                  ->orWhere('created_by', 'like', "%{$search}%")
                  ->orWhere('old_ip_address', 'like', "%{$search}%")
                  ->orWhere('new_ip_address', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($q2) use ($search) {
                      $q2->where('customer_id', 'like', "%{$search}%")
                         ->orWhere('customer_name', 'like', "%{$search}%")
                         ->orWhere('pppoe', 'like', "%{$search}%")
                         ->orWhere('province', 'like', "%{$search}%");
                  });
            });
        }
    
        /*
        |--------------------------------------------------------------------------
        | CUSTOM FILTERS (your dropdowns & inputs)
        |--------------------------------------------------------------------------
        */
    
        if ($request->request_type) {
            $query->where('request_type', $request->request_type);
        }
    
        if ($request->pppoe) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('pppoe', 'like', '%' . $request->pppoe . '%');
            });
        }
    
        if ($request->ip) {
            $query->where(function ($q) use ($request) {
                $q->where('old_ip_address', 'like', '%' . $request->ip . '%')
                  ->orWhere('new_ip_address', 'like', '%' . $request->ip . '%');
            });
        }
    
        if ($request->location) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('province', $request->location);
            });
        }
    
        if ($request->minDate) {
            $query->whereDate('date', '>=', $request->minDate);
        }
    
        if ($request->maxDate) {
            $query->whereDate('date', '<=', $request->maxDate);
        }
    
        // Count AFTER filtering
        $totalFiltered = $query->count();
    
        // Pagination
        $start  = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);
    
        $data = $query->orderBy('created_at', 'desc')
            ->skip($start)
            ->take($length)
            ->get();
    
        // Format dates
        $data = $data->map(function ($item) {
            $item->date = $item->date
                ? \Carbon\Carbon::parse($item->date)->format('d M, Y')
                : 'N/A';
    
            $item->formatted_created_at = $item->created_at
                ? $item->created_at->format('d M, Y')
                : 'N/A';
    
            return $item;
        });
    
        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $data,
        ]);
    }

    public function scheduleIndex()
    {
        $requestChanges = RequestChange::with('customer')
            ->where('status', 'Pending')
            // ->whereDate('date', '>=', Carbon::today()) // ✅ include today
            ->orderBy('date', 'asc') // upcoming first
            ->get()
            ->map(function ($item) {
                $item->date = $item->date
                    ? Carbon::parse($item->date)->format('d M, Y')
                    : 'N/A';
    
                $item->formatted_created_at = $item->created_at
                    ? $item->created_at->format('d M, Y')
                    : 'N/A';
    
                return $item;
            });
    
        return response()->json([
            'success' => true,
            'data' => $requestChanges->toArray()
        ]);
    }
    
    public function showSchedule($id)
    {
        $data = RequestChange::with('customer')->find($id);

        if ($data) {
            $data->formatted_created_at = Carbon::parse($data->created_at)
                ->format('d M, Y'); // example: 16 Dec 2025, 02:30 PM
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function completeRequest(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $requestId = $request->input('id');
            $requestType = $request->input('request_type');
            $customerId = $request->input('customer_id');
            
            // Find the request change record
            $requestChange = RequestChange::findOrFail($requestId);
            
            // Check if already completed
            if ($requestChange->status === 'Completed') {
                return response()->json([
                    'success' => false,
                    'message' => 'This request has already been completed.'
                ], 400);
            }
            
            // Verify customer exists
            $customerExists = DB::table('customers_info')
                ->where('customer_id', $customerId)
                ->exists();

            if (!$customerExists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Customer ID not found: ' . $customerId
                ], 404);
            }
            
            // ===== Update customers_info table =====
            $commonUpdateData = [
                'customer_name' => $requestChange->new_customer_name ?? $requestChange->old_customer_name,
                'pppoe' => $requestChange->new_pppoe ?? $requestChange->old_pppoe,
                'password' => $requestChange->new_pw ?? $requestChange->old_pw,
                'router' => $requestChange->new_router ?? $requestChange->old_router,
                'remark' => $requestChange->new_remark ?? $requestChange->old_remark,
            ];

            $specificUpdateData = [];
            
            switch ($requestType) {
                case 'Upgrade':
                case 'Downgrade':
                case 'Change Service':
                    $specificUpdateData = [
                        'tariff_name' => $requestChange->new_tariff,
                        'bandwidth' => $requestChange->new_bandwidth,
                    ];
                    break;

                case 'Relocation':
                    $specificUpdateData = [
                        'address_line_1' => $requestChange->new_address,
                        'alt_address_line_1' => $requestChange->new_alt_address ?? $requestChange->old_alt_address,
                        'province' => $requestChange->new_province,
                    ];
                    break;

                case 'Deactivate':
                case 'Reactivate':
                case 'Termination':
                    $specificUpdateData = [
                        'status' => $requestChange->new_customer_status
                    ];
                    break;
            }

            $updateData = array_merge($commonUpdateData, $specificUpdateData);
            $updateData = array_filter($updateData, fn($v) => !is_null($v) && $v !== '');

            if (!empty($updateData)) {
                $customer = Register::where('customer_id', $customerId)->first();

                if ($customer) {
                    $customer->fill($updateData);
                    $customer->save();
                }
            }

            // ===== Handle IpAddress DB changes =====
            switch ($requestType) {
                case 'Add IP Address':
                    // Parse old and new IP addresses
                    $oldIps = array_filter(array_map('trim', explode(',', $requestChange->old_ip_address ?? '')));
                    $newIps = array_filter(array_map('trim', explode(',', $requestChange->new_ip_address ?? '')));
                    
                    // Get IPs to add (those in new but not in old)
                    $ipsToAdd = array_diff($newIps, $oldIps);
                    
                    if (!empty($ipsToAdd)) {
                        $lastPosition = IpAddress::where('customer_id', $customerId)->max('position') ?? 0;
                        
                        foreach ($ipsToAdd as $index => $ip) {
                            if (!IpAddress::where('customer_id', $customerId)
                                        ->where('ip_address', $ip)
                                        ->exists()) {
                                IpAddress::create([
                                    'customer_id' => $customerId,
                                    'ip_address'  => $ip,
                                    'position'    => $lastPosition + $index + 1,
                                ]);
                            }
                        }
                    }
                    break;

                case 'Change IP Address':
                    // For change IP, we need to update existing IPs
                    // Since we don't have position data in the completed request,
                    // we'll replace all IPs with the new ones
                    $newIps = array_filter(array_map('trim', explode(',', $requestChange->new_ip_address ?? '')));
                    
                    if (!empty($newIps)) {
                        // Delete old IPs
                        IpAddress::where('customer_id', $customerId)->delete();
                        
                        // Add new IPs
                        foreach ($newIps as $index => $ip) {
                            IpAddress::create([
                                'customer_id' => $customerId,
                                'ip_address'  => $ip,
                                'position'    => $index + 1,
                            ]);
                        }
                    }
                    break;

                case 'Remove IP Address':
                    $oldIps = array_filter(array_map('trim', explode(',', $requestChange->old_ip_address ?? '')));
                    $remainingIps = array_filter(array_map('trim', explode(',', $requestChange->new_ip_address ?? '')));
                    
                    // Get IPs to remove (those in old but not in remaining)
                    $ipsToRemove = array_diff($oldIps, $remainingIps);
                    
                    if (!empty($ipsToRemove)) {
                        IpAddress::where('customer_id', $customerId)
                            ->whereIn('ip_address', $ipsToRemove)
                            ->delete();
                    }
                    break;
            }

            // Reorder IP positions after any IP changes
            if (in_array($requestType, ['Add IP Address', 'Change IP Address', 'Remove IP Address'])) {
                $ips = IpAddress::where('customer_id', $customerId)
                    ->orderBy('position')
                    ->get();
                    
                foreach ($ips as $index => $ip) {
                    $ip->position = $index + 1;
                    $ip->save();
                }
            }

            // ===== Update request status to completed =====
            $requestChange->status = 'Completed';
            $requestChange->updated_at = now();
            $requestChange->save();
            
            DB::commit();
            
            $message = match ($requestType) {
                'Add IP Address'     => 'IP Address added and request completed successfully!',
                'Remove IP Address'  => 'IP Address removed and request completed successfully!',
                'Change IP Address'  => 'IP Address changed and request completed successfully!',
                'Upgrade'            => 'Upgrade completed successfully!',
                'Downgrade'          => 'Downgrade completed successfully!',
                'Change Service'     => 'Service change completed successfully!',
                'Relocation'         => 'Relocation completed successfully!',
                'Deactivate'         => 'Deactivation completed successfully!',
                'Reactivate'         => 'Reactivation completed successfully!',
                'Termination'        => 'Termination completed successfully!',
                'Change Remark'      => 'Remark change completed successfully!',
                default              => 'Request completed successfully!',
            };
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $requestChange
            ]);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Request not found.'
            ], 404);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error completing request change', [
                'request_id' => $request->input('id'),
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to complete request: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAllRequestTestingData()
    {
        $requestTestings = RequestTesting::with('customer')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                $item->request_date = $item->request_date ? Carbon::parse($item->request_date)->format('d M, Y') : 'N/A';
                $item->end_testing_date = $item->end_testing_date ? Carbon::parse($item->end_testing_date)->format('d M, Y') : 'N/A';
                $item->formatted_created_at = $item->created_at ? $item->created_at->format('d M, Y') : 'N/A';
                return $item;
            });
        
        return response()->json([
            'success' => true,
            'data' => $requestTestings->toArray()
        ]);
    }
}
