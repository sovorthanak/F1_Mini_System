<?php

namespace App\Http\Controllers;

use App\Models\Bandwidth;
use App\Models\Location;
use App\Models\Register;
use App\Models\RequestChange;
use App\Models\Tariff;
use App\Models\IpAddress;
use App\Models\IpPool;
use App\Models\IpInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RequestChangeController extends Controller
{
    public function index(Request $request)
    {
        $locations = Location::where('status', true)->get(); // Only active ones

        $request_changes = RequestChange::orderBy('created_at', 'desc')->get();
        $total_requests = $request_changes->count();
        return view('request_change.index', compact('request_changes', 'total_requests', 'locations'));
    }

    public function create()
    {
        $tariffs = Tariff::where('status', 1)->pluck('name');
        $locations = Location::where('status', true)->get();
        $bandwidths = Bandwidth::where('status', 1)
            ->orderByRaw("CAST(REPLACE(speed, 'Mbps', '') AS UNSIGNED) ASC")
            ->get();

        // IP pool data (same as RegisterController)
        $pools = IpPool::where('is_active', true)->orderBy('name')->get();
        $freeByPool = IpInventory::where('status', 'free')->get()
            ->groupBy('ip_pool_id')
            ->map(fn($items) => $items->map(fn($i) => ['id' => $i->id, 'ip' => $i->ip_address])->values());

        return view('request_change.create', compact('tariffs', 'locations', 'bandwidths', 'pools', 'freeByPool'));
    }

    // public function store(Request $request)
    // {
    //     // dd($request->all()); // For debugging

    //     // ===== Base Validation Rules =====
    //     $rules = [
    //         'request_type' => 'required|string',
    //         'customer_id' => 'required|string|exists:customers_info,customer_id',
    //         'old_customer_name' => 'nullable|string',
    //         'new_customer_name' => 'nullable|string',
    //         'old_pppoe' => 'nullable|string',
    //         'new_pppoe' => 'nullable|string',
    //         'old_password' => 'nullable|string',
    //         'new_password' => 'nullable|string',
    //         'old_tariff_name' => 'nullable|string',
    //         'new_tariff_name' => 'nullable|string',
    //         'old_bandwidth' => 'nullable|string',
    //         'new_bandwidth' => 'nullable|string',
    //         'old_address' => 'nullable|string',
    //         'new_address' => 'nullable|string',
    //         'old_alt_address' => 'nullable|string',
    //         'new_alt_address' => 'nullable|string',
    //         'old_ip_address' => 'nullable|string|max:10000',
    //         'new_ip_address' => 'nullable|string|max:10000',
    //         'old_location' => 'nullable|string',
    //         'new_location' => 'nullable|string',
    //         'old_customer_status' => 'nullable|string',
    //         'new_customer_status' => 'nullable|string',
    //         'old_router' => 'nullable|string',
    //         'new_router' => 'nullable|string',
    //         'old_remark' => 'nullable|string|max:1000',
    //         'remark' => 'nullable|string|max:1000',
    //         'date' => 'required|date',
    //         'old_ip_address_array' => 'nullable|array',
    //         'old_ip_address_array.*.ip_address' => 'nullable|string',
    //         'old_ip_address_array.*.position' => 'nullable|integer',
    //         'new_ip_address_array' => 'nullable|array',
    //         'new_ip_address_array.*.ip_address' => 'nullable|string',
    //         'new_ip_address_array.*.position' => 'nullable|integer',
    //         'remove_ip_array' => 'nullable|array',
    //         'remove_ip_array.*.ip_address' => 'nullable|string',
    //         'remove_ip_array.*.position' => 'nullable|integer',
    //     ];

    //     // ===== Dynamic Validation =====
    //     switch ($request->request_type) {
    //         case 'Upgrade':
    //         case 'Downgrade':
    //         case 'Change Service':
    //             $rules['old_tariff_name'] = 'required|string';
    //             $rules['new_tariff_name'] = 'required|string';
    //             $rules['old_bandwidth'] = 'required|string';
    //             $rules['new_bandwidth'] = 'required|string';
    //             break;

    //         case 'Relocation':
    //             $rules['old_location'] = 'required|string';
    //             $rules['new_location'] = 'required|string';
    //             $rules['new_address'] = 'required|string';
    //             break;

    //         case 'Deactivate':
    //         case 'Reactivate':
    //         case 'Termination':
    //             $rules['old_customer_status'] = 'required|in:Active,Inactive,Suspended,Terminated,Deactivated,Pending';
    //             $rules['new_customer_status'] = 'required|in:Active,Inactive,Suspended,Terminated,Deactivated,Pending';
    //             break;

    //         case 'Add IP Address':
    //         case 'Remove IP Address':
    //         case 'Change IP Address':
    //             if ($request->has('new_ip_address_array') && is_array($request->new_ip_address_array) && !empty(array_filter($request->new_ip_address_array, fn($ip) => !empty($ip['ip_address'])))) {
    //                 $rules['new_ip_address_array'] = 'required|array|min:1';
    //                 $rules['new_ip_address_array.*.ip_address'] = 'required|string';
    //                 if ($request->has('old_ip_address_array')) {
    //                     $rules['old_ip_address_array.*.ip_address'] = 'required|string';
    //                 }
    //             } else {
    //                 $rules['old_ip_address'] = 'required|string';
    //                 $rules['new_ip_address'] = 'required|string';
    //             }
    //             break;
    //     }

    //     $validated = $request->validate($rules);

    //     // ===== 🔥 AUTO-CHECK DATE: Is it today/past or future? =====
    //     $requestDate = Carbon::parse($request->date)->startOfDay();
    //     $today = Carbon::today();
        
    //     // If date is today or in the past → Process NOW (Completed)
    //     // If date is in the future → Keep as Pending (scheduled)
    //     $shouldProcessNow = $requestDate->lte($today);
        
    //     // Set status based on date
    //     $initialStatus = $shouldProcessNow ? 'Completed' : 'Pending';

    //     // ===== Success Messages =====
    //     $message = match ($request->request_type) {
    //         'Add IP Address'     => 'IP Address added successfully!',
    //         'Remove IP Address'  => 'IP Address removed successfully!',
    //         'Change IP Address'  => 'IP Address changed successfully!',
    //         'Upgrade'            => 'Upgrade request saved successfully!',
    //         'Downgrade'          => 'Downgrade request saved successfully!',
    //         'Change Service'     => 'Change Service request saved successfully!',
    //         'Relocation'         => 'Relocation request saved successfully!',
    //         'Deactivate'         => 'Deactivation request saved successfully!',
    //         'Reactivate'         => 'Reactivation request saved successfully!',
    //         'Termination'        => 'Termination request saved successfully!',
    //         default              => 'Request saved successfully!',
    //     };

    //     try {
    //         // ===== Ensure Customer Exists =====
    //         $customerExists = DB::table('customers_info')
    //             ->where('customer_id', $request->customer_id)
    //             ->exists();

    //         if (!$customerExists) {
    //             return redirect()->back()->with('error', 'Customer ID not found: ' . $request->customer_id);
    //         }

    //         // ===== Create RequestChange Record =====
    //         $requestChange = RequestChange::create([
    //             'request_type' => $request->request_type,
    //             'customer_id' => $request->customer_id,
    //             'old_customer_name' => $request->old_customer_name ?? '',
    //             'new_customer_name' => $request->new_customer_name ?? '',
    //             'old_pppoe' => $request->old_pppoe ?? '',
    //             'new_pppoe' => $request->new_pppoe ?? '',
    //             'old_pw' => $request->old_password ?? '',
    //             'new_pw' => $request->new_password ?? '',
    //             'old_tariff' => $request->old_tariff_name ?? '',
    //             'new_tariff' => $request->new_tariff_name ?? '',
    //             'old_bandwidth' => $request->old_bandwidth ?? '',
    //             'new_bandwidth' => $request->new_bandwidth ?? '',
    //             'old_address' => $request->old_address ?? '',
    //             'new_address' => $request->new_address ?? '',
    //             'old_alt_address' => $request->old_alt_address ?? '',
    //             'new_alt_address' => $request->new_alt_address ?? '',
    //             'old_province' => $request->old_location ?? '',
    //             'new_province' => $request->new_location ?? '',
    //             'old_customer_status' => $request->old_customer_status ?? '',
    //             'new_customer_status' => $request->new_customer_status ?? '',
    //             'old_router' => $request->old_router ?? '',
    //             'new_router' => $request->new_router ?? '',
    //             'old_remark' => $request->old_remark ?? '',
    //             'new_remark' => $request->remark ?? '',
    //             'date' => $request->date,
    //             'status' => $initialStatus, // Auto-determined by date
    //             'processed_at' => $shouldProcessNow ? now() : null, // Track when it was processed
    //         ]);

    //         // ===== IP Handling =====
    //         $oldIps = $request->input('old_ip_address_array', []);
    //         $newIps = $request->input('new_ip_address_array', []);
    //         $removeIps = $request->input('remove_ip_array', []);

    //         $oldIpAddresses = array_map(fn($ip) => $ip['ip_address'], $oldIps);

    //         switch ($request->request_type) {
    //             case 'Add IP Address':
    //                 $newIpAddresses = array_map(fn($ip) => $ip['ip_address'], $newIps);
    //                 $allCombinedIps = array_unique(array_merge($oldIpAddresses, $newIpAddresses));
    //                 $requestChange->old_ip_address = implode(', ', $oldIpAddresses);
    //                 $requestChange->new_ip_address = implode(', ', $allCombinedIps);
    //                 break;

    //             case 'Change IP Address':
    //                 $newIpAddresses = array_map(fn($ip) => $ip['ip_address'], $newIps);
    //                 $requestChange->old_ip_address = implode(', ', array_unique($oldIpAddresses));
    //                 $requestChange->new_ip_address = implode(', ', array_unique($newIpAddresses));
    //                 break;

    //             case 'Remove IP Address':
    //                 $remainingIpAddresses = array_map(fn($ip) => $ip['ip_address'], $newIps);
    //                 $requestChange->old_ip_address = implode(', ', $oldIpAddresses);
    //                 $requestChange->new_ip_address = implode(', ', $remainingIpAddresses);
    //                 break;

    //             default:
    //                 if (!empty($newIps)) {
    //                     $requestChange->new_ip_address = implode(', ', array_map(fn($ip) => $ip['ip_address'], $newIps));
    //                 }
    //                 if (!empty($oldIps)) {
    //                     $requestChange->old_ip_address = implode(', ', $oldIpAddresses);
    //                 }
    //                 break;
    //         }

    //         $requestChange->save();

    //         // ===== 🔥 ONLY UPDATE customers_info IF DATE IS TODAY OR PAST =====
    //         if ($shouldProcessNow) {
    //             // ===== Update customers_info table =====
    //             $commonUpdateData = [
    //                 'customer_name' => $request->new_customer_name ?? $request->old_customer_name,
    //                 'pppoe' => $request->new_pppoe ?? $request->old_pppoe,
    //                 'password' => $request->new_password ?? $request->old_password,
    //                 'router' => $request->new_router ?? $request->old_router,
    //                 'remark' => $request->remark ?? $request->old_remark,
    //             ];

    //             $specificUpdateData = [];
    //             switch ($request->request_type) {
    //                 case 'Upgrade':
    //                 case 'Downgrade':
    //                 case 'Change Service':
    //                     $specificUpdateData = [
    //                         'tariff_name' => $request->new_tariff_name,
    //                         'bandwidth' => $request->new_bandwidth,
    //                     ];
    //                     break;

    //                 case 'Relocation':
    //                     $specificUpdateData = [
    //                         'address_line_1' => $request->new_address,
    //                         'alt_address_line_1' => $request->new_alt_address ?? $request->old_alt_address,
    //                         'province' => $request->new_location,
    //                     ];
    //                     break;

    //                 case 'Deactivate':
    //                 case 'Reactivate':
    //                 case 'Termination':
    //                     $specificUpdateData = ['status' => $request->new_customer_status];
    //                     break;
    //             }

    //             $updateData = array_merge($commonUpdateData, $specificUpdateData);
    //             $updateData = array_filter($updateData, fn($v) => !is_null($v) && $v !== '');

    //             if (!empty($updateData)) {
    //                 $customer = Register::where('customer_id', $request->customer_id)->first();

    //                 if ($customer) {
    //                     $customer->fill($updateData);
    //                     $customer->save();
    //                 }
    //             }

    //             // ===== Handle IpAddress DB changes (only if processing now) =====
    //             switch ($request->request_type) {
    //                 case 'Add IP Address':
    //                     $newIpAddresses = array_map(fn($ip) => $ip['ip_address'], $newIps);
    //                     $lastPosition = IpAddress::where('customer_id', $request->customer_id)->max('position') ?? 0;
    //                     foreach ($newIpAddresses as $index => $ip) {
    //                         if (!IpAddress::where('customer_id', $request->customer_id)->where('ip_address', $ip)->exists()) {
    //                             IpAddress::create([
    //                                 'customer_id' => $request->customer_id,
    //                                 'ip_address'  => $ip,
    //                                 'position'    => $lastPosition + $index + 1,
    //                             ]);
    //                         }
    //                     }
    //                     break;

    //                 case 'Change IP Address':
    //                     foreach ($newIps as $ipData) {
    //                         IpAddress::where('customer_id', $request->customer_id)
    //                             ->where('position', $ipData['position'])
    //                             ->update(['ip_address' => $ipData['ip_address']]);
    //                     }
    //                     break;

    //                 case 'Remove IP Address':
    //                     $remainingIpAddresses = array_map(fn($ip) => trim($ip['ip_address']), $newIps);
    //                     IpAddress::where('customer_id', $request->customer_id)
    //                         ->whereNotIn('ip_address', $remainingIpAddresses)
    //                         ->delete();
    //                     break;
    //             }

    //             // Reorder IP positions (only if processing now)
    //             $ips = IpAddress::where('customer_id', $request->customer_id)
    //                 ->orderBy('position')
    //                 ->get();
    //             foreach ($ips as $index => $ip) {
    //                 $ip->position = $index + 1;
    //                 $ip->save();
    //             }

    //             // Update success message
    //             $message .= ' Changes have been applied to customer immediately.';
    //         } else {
    //             // If scheduled for future
    //             $message .= ' Request is scheduled for ' . $requestDate->format('F j, Y') . '.';
    //         }

    //         return redirect()->route('request-change')->with('success', $message);

    //     } catch (\Exception $e) {
    //         Log::error('Error processing request change', [
    //             'message' => $e->getMessage(),
    //             'request_data' => $request->all(),
    //             'trace' => $e->getTraceAsString(),
    //         ]);
    //         return redirect()->back()->with('error', 'Failed to process request change: ' . $e->getMessage());
    //     }
    // }

    /* =========================
    ✅ COMMON VALIDATION RULES
    ========================= */
    private function commonRules(): array
    {
        return [
            'customer_id'       => 'required|string|exists:customers_info,customer_id',
            'date'              => 'required|date',
            'old_customer_name' => 'nullable|string',
            'new_customer_name' => 'nullable|string',
            'old_pppoe'         => 'nullable|string',
            'new_pppoe'         => 'nullable|string',
            'old_password'      => 'nullable|string',
            'new_password'      => 'nullable|string',
            'old_router'        => 'nullable|string',
            'new_router'        => 'nullable|string',
        ];
    }

    /* =========================
    ✅ STORE: Tariff (Upgrade / Downgrade / Change Service)
    ========================= */
    public function storeTariff(Request $request)
    {
        $data = $request->validate(array_merge($this->commonRules(), [
            'request_type'     => 'required|in:Upgrade,Downgrade,Change Service',
            'old_tariff_name'  => 'required|string',
            'new_tariff_name'  => 'required|string',
            'old_bandwidth'    => 'required|string',
            'new_bandwidth'    => 'required|string',
        ]));

        return $this->processRequest($data);
    }

    /* =========================
    ✅ STORE: Status (Deactivate / Reactivate / Termination)
    ========================= */
    public function storeStatus(Request $request)
    {
        $allowed = 'Active,Inactive,Suspended,Terminated,Deactivated,Pending';

        $data = $request->validate(array_merge($this->commonRules(), [
            'request_type'        => 'required|in:Deactivate,Reactivate,Termination',
            'old_customer_status' => "required|in:$allowed",
            'new_customer_status' => "required|in:$allowed",
        ]));

        return $this->processRequest($data);
    }

    /* =========================
    ✅ STORE: Relocation
    ========================= */
    public function storeRelocation(Request $request)
    {
        $data = $request->validate(array_merge($this->commonRules(), [
            'request_type'    => 'required|in:Relocation',
            'old_address'     => 'nullable|string',
            'new_address'     => 'required|string',
            'old_alt_address' => 'nullable|string',
            'new_alt_address' => 'nullable|string',
            'old_location'    => 'required|string',
            'new_location'    => 'required|string',
        ]));

        return $this->processRequest($data);
    }

    /* =========================
    ✅ STORE: Remark (Change Remark)
    ========================= */
    public function storeRemark(Request $request)
    {
        $data = $request->validate(array_merge($this->commonRules(), [
            'request_type' => 'required|in:Change Remark',
            'old_remark'   => 'nullable|string|max:1000',
            'remark'       => 'required|string|max:1000',
        ]));

        return $this->processRequest($data);
    }

    /* =========================
    ✅ STORE: Add IP Address
    ========================= */
    public function storeAddIp(Request $request)
    {
        $rules = array_merge($this->commonRules(), [
            'request_type' => 'required|in:Add IP Address',
        ]);

        $rules = array_merge($rules, $this->ipRules($request));

        $data = $request->validate($rules);
        return $this->processRequest($data);
    }

    /* =========================
    ✅ STORE: Remove IP Address
    ========================= */
    public function storeRemoveIp(Request $request)
    {
        $rules = array_merge($this->commonRules(), [
            'request_type' => 'required|in:Remove IP Address',
        ]);

        // Pool-based: only need remove_ids + old_ip_ids (no new ip_items needed)
        if ($request->has('remove_ids')) {
            $rules['remove_ids']  = 'required|string';
            $rules['old_ip_ids']  = 'nullable|string';
            $rules['ip_items']    = 'nullable|array';
            $rules['ip_items.*.id']   = 'nullable|integer';
            $rules['ip_items.*.note'] = 'nullable|string|max:255';
        } else {
            $rules = array_merge($rules, $this->ipRules($request));
        }

        $data = $request->validate($rules);
        return $this->processRequest($data);
    }

    /* =========================
    ✅ STORE: Change IP Address
    ========================= */
    public function storeChangeIp(Request $request)
    {
        $rules = array_merge($this->commonRules(), [
            'request_type' => 'required|in:Change IP Address',
        ]);

        // New per-IP change format: change_items[]
        if ($request->has('change_items') && is_array($request->change_items)) {
            $rules['change_items']          = 'required|array|min:1';
            $rules['change_items.*.old_id'] = 'required|integer';
            $rules['change_items.*.new_id'] = 'required|integer';
            $rules['change_items.*.note']   = 'nullable|string|max:255';
            $rules['old_ip_ids']            = 'nullable|string';
        } else {
            $rules = array_merge($rules, $this->ipRules($request));
        }

        $data = $request->validate($rules);
        return $this->processRequest($data);
    }

    /* =========================
    ✅ IP VALIDATION RULES (shared by Add/Remove/Change IP)
    ========================= */
    private function ipRules(Request $request): array
    {
        // New pool-based format: ip_items[].id + ip_items[].note
        if ($request->has('ip_items') && is_array($request->ip_items)) {
            return [
                'ip_items'        => 'required|array|min:1',
                'ip_items.*.id'   => 'required|integer',
                'ip_items.*.note' => 'nullable|string|max:255',
                'remove_ids'      => 'nullable|string',  // comma-separated inventory IDs to remove
                'old_ip_ids'      => 'nullable|string',   // comma-separated old inventory IDs
            ];
        }

        // Legacy format fallback
        $hasArrayIps = is_array($request->new_ip_address_array)
            && !empty(array_filter($request->new_ip_address_array, fn($ip) => !empty($ip['ip_address'])));

        if ($hasArrayIps) {
            return [
                'old_ip_address_array'              => 'nullable|array',
                'old_ip_address_array.*.ip_address'  => 'required|string',
                'old_ip_address_array.*.position'    => 'nullable|integer',
                'new_ip_address_array'              => 'required|array|min:1',
                'new_ip_address_array.*.ip_address'  => 'required|string',
                'new_ip_address_array.*.position'    => 'nullable|integer',
                'remove_ip_array'                   => 'nullable|array',
                'remove_ip_array.*.ip_address'       => 'nullable|string',
                'remove_ip_array.*.position'         => 'nullable|integer',
            ];
        }

        return [
            'old_ip_address' => 'required|string|max:10000',
            'new_ip_address' => 'required|string|max:10000',
        ];
    }

    /* =========================
    ✅ SHARED: Process validated request data
    ========================= */
    private function processRequest(array $data)
    {
        $requestDate      = Carbon::parse($data['date'])->startOfDay();
        $shouldProcessNow = $requestDate->lte(Carbon::today());
        $status           = $shouldProcessNow ? 'Completed' : 'Pending';

        $message = $this->successMessage($data['request_type']);

        try {
            DB::transaction(function () use (&$requestChange, $data, $status, $shouldProcessNow) {

                // 1) create request change
                $requestChange = $this->createRequestChange($data, $status, $shouldProcessNow);

                // 2) store old/new ip strings into request_changes
                $this->storeRequestChangeIps($requestChange, $data);

                // 3) if date is today/past => apply to customer + ip_addresses now
                if ($shouldProcessNow) {
                    $this->applyCustomerNow($data);
                    $this->applyIpsNow($data);
                    $this->reorderIpPositions($data['customer_id']);
                }
            });

            if ($shouldProcessNow) {
                $message .= ' Changes have been applied to customer immediately.';
            } else {
                $message .= ' Request is scheduled for ' . $requestDate->format('F j, Y') . '.';
            }

            return redirect()->route('request-change')->with('success', $message);

        } catch (\Throwable $e) {
            Log::error('Error processing request change', [
                'message'      => $e->getMessage(),
                'request_type' => $data['request_type'] ?? 'unknown',
            ]);

            return redirect()->back()->with('error', 'Failed to process request change: ' . $e->getMessage());
        }
    }

    private function successMessage(string $type): string
    {
        return match ($type) {
            'Add IP Address'     => 'IP Address added successfully!',
            'Remove IP Address'  => 'IP Address removed successfully!',
            'Change IP Address'  => 'IP Address changed successfully!',
            'Upgrade'            => 'Upgrade request saved successfully!',
            'Downgrade'          => 'Downgrade request saved successfully!',
            'Change Service'     => 'Change Service request saved successfully!',
            'Relocation'         => 'Relocation request saved successfully!',
            'Deactivate'         => 'Deactivation request saved successfully!',
            'Reactivate'         => 'Reactivation request saved successfully!',
            'Termination'        => 'Termination request saved successfully!',
            'Change Remark'      => 'Remark changed successfully!',
            default              => 'Request saved successfully!',
        };
    }

    /* =========================
    ✅ CREATE REQUEST CHANGE
    ========================= */
    private function createRequestChange(array $data, string $status, bool $processedNow): RequestChange
    {
        return RequestChange::create([
            'request_type' => $data['request_type'],
            'customer_id'  => $data['customer_id'],

            'old_customer_name' => $data['old_customer_name'] ?? '',
            'new_customer_name' => $data['new_customer_name'] ?? '',

            'old_pppoe' => $data['old_pppoe'] ?? '',
            'new_pppoe' => $data['new_pppoe'] ?? '',

            'old_pw' => $data['old_password'] ?? '',
            'new_pw' => $data['new_password'] ?? '',

            'old_tariff' => $data['old_tariff_name'] ?? '',
            'new_tariff' => $data['new_tariff_name'] ?? '',

            'old_bandwidth' => $data['old_bandwidth'] ?? '',
            'new_bandwidth' => $data['new_bandwidth'] ?? '',

            'old_address' => $data['old_address'] ?? '',
            'new_address' => $data['new_address'] ?? '',

            'old_alt_address' => $data['old_alt_address'] ?? '',
            'new_alt_address' => $data['new_alt_address'] ?? '',

            'old_province' => $data['old_location'] ?? '',
            'new_province' => $data['new_location'] ?? '',

            'old_customer_status' => $data['old_customer_status'] ?? '',
            'new_customer_status' => $data['new_customer_status'] ?? '',

            'old_router' => $data['old_router'] ?? '',
            'new_router' => $data['new_router'] ?? '',

            'old_remark' => $data['old_remark'] ?? '',
            'new_remark' => $data['remark'] ?? '',

            'date' => $data['date'],
            'status' => $status,
            'processed_at' => $processedNow ? now() : null,
        ]);
    }

    /* =========================
    ✅ IP STRING ON REQUEST_CHANGE
    ========================= */
    private function storeRequestChangeIps(RequestChange $rc, array $data): void
    {
        $type = $data['request_type'];

        // ✅ Per-IP change format: change_items[]
        if ($type === 'Change IP Address' && isset($data['change_items'])) {
            $changeItems = collect($data['change_items']);

            $oldIds = $changeItems->pluck('old_id')->filter()->toArray();
            $newIds = $changeItems->pluck('new_id')->filter()->toArray();

            $oldIpStrings = !empty($oldIds) ? IpInventory::whereIn('id', $oldIds)->pluck('ip_address')->toArray() : [];
            $newIpStrings = !empty($newIds) ? IpInventory::whereIn('id', $newIds)->pluck('ip_address')->toArray() : [];

            $rc->old_ip_address = implode(', ', $oldIpStrings);
            $rc->new_ip_address = implode(', ', $newIpStrings);
            $rc->save();
            return;
        }

        // New pool-based format (detect by ip_items, remove_ids, or old_ip_ids)
        if (isset($data['ip_items']) || isset($data['remove_ids']) || isset($data['old_ip_ids'])) {
            $cid = $data['customer_id'];

            // Old IPs: from old_ip_ids (comma-separated inventory IDs)
            $oldIpIds = array_filter(explode(',', $data['old_ip_ids'] ?? ''));
            $oldIpStrings = [];
            if (!empty($oldIpIds)) {
                $oldIpStrings = IpInventory::whereIn('id', $oldIpIds)->pluck('ip_address')->toArray();
            }

            // New IPs: from ip_items[].id (inventory IDs)
            $newItemIds = collect($data['ip_items'] ?? [])->pluck('id')->filter()->toArray();
            $newIpStrings = !empty($newItemIds) ? IpInventory::whereIn('id', $newItemIds)->pluck('ip_address')->toArray() : [];

            if ($type === 'Add IP Address') {
                $rc->old_ip_address = implode(', ', $oldIpStrings);
                $rc->new_ip_address = implode(', ', array_values(array_unique(array_merge($oldIpStrings, $newIpStrings))));
            } elseif ($type === 'Remove IP Address') {
                $removeIds = array_filter(explode(',', $data['remove_ids'] ?? ''));
                $removeIpStrings = [];
                if (!empty($removeIds)) {
                    $removeIpStrings = IpInventory::whereIn('id', $removeIds)->pluck('ip_address')->toArray();
                }
                $remainingIps = array_diff($oldIpStrings, $removeIpStrings);
                $rc->old_ip_address = implode(', ', $oldIpStrings);
                $rc->new_ip_address = implode(', ', array_values($remainingIps));
            }

            $rc->save();
            return;
        }

        // Legacy format
        $oldIps = $this->pluckIps($data['old_ip_address_array'] ?? []);
        $newIps = $this->pluckIps($data['new_ip_address_array'] ?? []);

        if ($type === 'Add IP Address') {
            $rc->old_ip_address = implode(', ', $oldIps);
            $rc->new_ip_address = implode(', ', array_values(array_unique(array_merge($oldIps, $newIps))));
        } elseif ($type === 'Change IP Address') {
            $rc->old_ip_address = implode(', ', array_values(array_unique($oldIps)));
            $rc->new_ip_address = implode(', ', array_values(array_unique($newIps)));
        } elseif ($type === 'Remove IP Address') {
            $rc->old_ip_address = implode(', ', $oldIps);
            $rc->new_ip_address = implode(', ', $newIps);
        } else {
            if ($oldIps) $rc->old_ip_address = implode(', ', $oldIps);
            if ($newIps) $rc->new_ip_address = implode(', ', $newIps);
        }

        $rc->save();
    }

    private function pluckIps(array $rows): array
    {
        return array_values(array_filter(array_map(
            fn($r) => trim($r['ip_address'] ?? ''),
            $rows
        )));
    }

    /* =========================
    ✅ APPLY CUSTOMER NOW
    ========================= */
    private function applyCustomerNow(array $data): void
    {
        $common = [
            'customer_name' => $data['new_customer_name'] ?? $data['old_customer_name'] ?? null,
            'pppoe'         => $data['new_pppoe'] ?? $data['old_pppoe'] ?? null,
            'password'      => $data['new_password'] ?? $data['old_password'] ?? null,
            'router'        => $data['new_router'] ?? $data['old_router'] ?? null,
            'remark'        => $data['remark'] ?? $data['old_remark'] ?? null,
        ];

        $specific = match ($data['request_type']) {
            'Upgrade', 'Downgrade', 'Change Service' => [
                'tariff_name' => $data['new_tariff_name'] ?? null,
                'bandwidth'   => $data['new_bandwidth'] ?? null,
            ],
            'Relocation' => [
                'address_line_1'     => $data['new_address'] ?? null,
                'alt_address_line_1' => $data['new_alt_address'] ?? $data['old_alt_address'] ?? null,
                'province'           => $data['new_location'] ?? null,
            ],
            'Deactivate', 'Reactivate', 'Termination' => [
                'status' => $data['new_customer_status'] ?? null,
            ],
            default => [],
        };

        $update = array_filter(array_merge($common, $specific), fn($v) => !is_null($v) && $v !== '');

        if (!$update) return;

        $customer = Register::where('customer_id', $data['customer_id'])->first();
        if ($customer) {
            $customer->fill($update)->save();
        }
    }

    /* =========================
    ✅ APPLY IP NOW
    ========================= */
    private function applyIpsNow(array $data): void
    {
        $type = $data['request_type'];
        $cid  = $data['customer_id'];

        // ✅ Per-IP change format: change_items[]
        if ($type === 'Change IP Address' && isset($data['change_items'])) {
            foreach ($data['change_items'] as $item) {
                // Free the old IP
                $oldInv = IpInventory::find($item['old_id']);
                if ($oldInv && $oldInv->customer_id == $cid) {
                    $oldInv->update(['customer_id' => null, 'status' => 'free', 'note' => null]);
                }

                // Assign the new IP
                $newInv = IpInventory::find($item['new_id']);
                if ($newInv) {
                    $newInv->update([
                        'customer_id' => $cid,
                        'status'      => 'assigned',
                        'note'        => $item['note'] ?? null,
                    ]);
                }
            }
            return;
        }

        // New pool-based format (detect by ip_items, remove_ids, or old_ip_ids)
        if (isset($data['ip_items']) || isset($data['remove_ids']) || isset($data['old_ip_ids'])) {
            $ipItems = collect($data['ip_items'] ?? []);

            if ($type === 'Add IP Address') {
                // Assign selected free IPs to this customer
                foreach ($ipItems as $item) {
                    $inv = IpInventory::find($item['id']);
                    if ($inv && $inv->status === 'free') {
                        $inv->update([
                            'customer_id' => $cid,
                            'status'      => 'assigned',
                            'note'        => $item['note'] ?? null,
                        ]);
                    }
                }
            }

            if ($type === 'Remove IP Address') {
                // Free the IPs marked for removal
                $removeIds = array_filter(explode(',', $data['remove_ids'] ?? ''));
                if (!empty($removeIds)) {
                    IpInventory::whereIn('id', $removeIds)
                        ->where('customer_id', $cid)
                        ->update(['customer_id' => null, 'status' => 'free', 'note' => null]);
                }
            }

            return;
        }

        // Legacy format
        $newRows = $data['new_ip_address_array'] ?? [];

        if ($type === 'Add IP Address') {
            $newIps = $this->pluckIps($newRows);
            $lastPosition = IpAddress::where('customer_id', $cid)->max('position') ?? 0;

            foreach ($newIps as $i => $ip) {
                if (!IpAddress::where('customer_id', $cid)->where('ip_address', $ip)->exists()) {
                    IpAddress::create([
                        'customer_id' => $cid,
                        'ip_address'  => $ip,
                        'position'    => $lastPosition + $i + 1,
                    ]);
                }
            }
        }

        if ($type === 'Change IP Address') {
            foreach ($newRows as $row) {
                if (empty($row['position']) || empty($row['ip_address'])) continue;

                IpAddress::where('customer_id', $cid)
                    ->where('position', $row['position'])
                    ->update(['ip_address' => $row['ip_address']]);
            }
        }

        if ($type === 'Remove IP Address') {
            $remaining = array_values(array_filter(array_map(fn($r) => trim($r['ip_address'] ?? ''), $newRows)));

            IpAddress::where('customer_id', $cid)
                ->whereNotIn('ip_address', $remaining)
                ->delete();
        }
    }

    private function reorderIpPositions(string $customerId): void
    {
        $ips = IpAddress::where('customer_id', $customerId)->orderBy('position')->get();
        foreach ($ips as $index => $ip) {
            $ip->update(['position' => $index + 1]);
        }
    }

    
    public function destroy($id)
    {
        $requestChange = RequestChange::findOrFail($id);
        $requestChange->delete();
        return back()->with('success', 'Request deleted successfully!');
    }

    public function show($id)
    {
        $requestChange = RequestChange::with('customer')->findOrFail($id);

        return view('request_change.show', compact('requestChange'));
    }
}