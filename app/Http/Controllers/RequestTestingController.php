<?php

namespace App\Http\Controllers;

use App\Models\Bandwidth;
use App\Models\Location;
use App\Models\Register;
use Illuminate\Http\Request;
use App\Models\RequestTesting;
use App\Models\Tariff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequestTestingController extends Controller
{
    public function index()
    {
        $request_testing = RequestTesting::orderBy('created_at', 'desc')->get();
        $total_requests = $request_testing->count();
        return view('request_testing.index', compact('request_testing', 'total_requests'));
    }

    public function create()
    {
        $tariffs = Tariff::where('status', 1)->pluck('name');
        $locations = Location::where('status', true)->get();
        $bandwidths = Bandwidth::where('status', 1)
            ->orderByRaw("CAST(REPLACE(speed, 'Mbps', '') AS UNSIGNED) ASC")
            ->get();
        return view('request_testing.create', compact('tariffs', 'locations', 'bandwidths'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'request_type' => ['required', 'in:Testing Upgrade,Testing Change Service'],
            'customer_id' => ['required'],

            'new_customer_name' => ['nullable', 'string'],
            'new_tariff' => ['required', 'string'],
            'new_bandwidth' => ['required', 'string'],
            'new_pppoe' => ['nullable', 'string'],
            'new_pw' => ['nullable', 'string'],
            'new_router' => ['nullable', 'string'],

            'request_date' => ['required', 'date'],
            'end_testing_date' => ['required', 'date', 'after_or_equal:request_date'],
            'remark' => ['nullable', 'string'],
        ]);

        return DB::transaction(function () use ($data) {
            // Lock the customer row so two tests can't apply at the same time
            $customer = Register::where('customer_id', $data['customer_id'])
                ->lockForUpdate()
                ->firstOrFail();

            // Block if already has active testing
            $hasActive = RequestTesting::where('customer_id', $customer->customer_id)
                ->where('status', 'Active')
                ->exists();

            if ($hasActive) {
                return back()->with('error', 'This customer already has an Active testing request.');
            }

            // 1) Save old data snapshot from DB (NOT from form)
            $req = RequestTesting::create([
                'request_type' => $data['request_type'],
                'customer_id' => $customer->customer_id,

                'old_customer_name' => $customer->customer_name ?? $customer->name ?? null,
                'old_tariff'        => $customer->tariff ?? $customer->tariff_name ?? null,
                'old_bandwidth'     => $customer->bandwidth ?? null,
                'old_pppoe'         => $customer->pppoe ?? null,
                'old_pw'            => $customer->pw ?? $customer->password ?? null,
                'old_router'        => $customer->router ?? null,

                'new_customer_name' => $data['new_customer_name'] ?? null,
                'new_tariff'        => $data['new_tariff'],
                'new_bandwidth'     => $data['new_bandwidth'],
                'new_pppoe'         => $data['new_pppoe'] ?? null,
                'new_pw'            => $data['new_pw'] ?? null,
                'new_router'        => $data['new_router'] ?? null,

                'request_date'      => $data['request_date'],
                'end_testing_date'  => $data['end_testing_date'],
                'remark'            => $data['remark'] ?? null,

                'status' => 'Active',
            ]);

            // 2) Apply new values to customer
            $customer->update([
                // change these column names to match your registers table columns
                'tariff'    => $data['new_tariff'],
                'bandwidth' => $data['new_bandwidth'],
                'status'    => 'Testing',

                // Only update these if you REALLY want them to change during testing
                // 'pppoe' => $data['new_pppoe'],
                // 'pw' => $data['new_pw'],
                // 'router' => $data['new_router'],
                // 'customer_name' => $data['new_customer_name'],
            ]);

            return redirect()
                ->route('request-testing', $req->id)
                ->with('success', 'Testing request created and applied to customer.');
        });
    }

    public function complete($id)
    {
        return DB::transaction(function () use ($id) {
            $req = RequestTesting::lockForUpdate()->findOrFail($id);

            if ($req->status !== 'Active') {
                return back()->with('error', 'This request is not Active.');
            }

            // (Optional) block completing before end date
            // if (now()->toDateString() < \Carbon\Carbon::parse($req->end_testing_date)->toDateString()) {
            //     return back()->with('error', 'Cannot complete before End Testing Date.');
            // }

            $customer = Register::where('customer_id', $req->customer_id)
                ->lockForUpdate()
                ->firstOrFail();

            // Restore old values
            $customer->update([
                'tariff'    => $req->old_tariff,
                'bandwidth' => $req->old_bandwidth,
                'status'    => 'Active',

                // restore only if you changed them in store()
                // 'pppoe' => $req->old_pppoe,
                // 'pw' => $req->old_pw,
                // 'router' => $req->old_router,
                // 'customer_name' => $req->old_customer_name,
            ]);

            $req->update([
                'status' => 'Completed',
            ]);

            return redirect()
                ->route('request-testing')
                ->with('success', 'Testing completed and customer restored to old info.');
        });
    }
    
    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {
            $req = RequestTesting::lockForUpdate()->findOrFail($id);

            if ($req->status !== 'Completed') {
                return back()->with('error', 'Only Completed requests can be deleted.');
            }

            $req->delete();

            return redirect()
                ->route('request-testing')
                ->with('success', 'Testing request deleted successfully.');
        });
    }
}
