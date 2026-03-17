<?php

namespace App\Http\Controllers;

use App\Models\CaseModel;
use App\Models\Location;
use App\Models\Register;
use App\Models\Tariff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CaseController extends Controller
{
    public function index()
    {
        $locations = Location::where('status', true)->get(); // Only active ones
        
        // Get statistics for dashboard cards
        $totalCases = CaseModel::count();
        $inProgressCases = CaseModel::where('status', 'In Progress')->count();
        $completedCases = CaseModel::where('status', 'Completed')->count();
        
        // Get all unique case types for the filter dropdown
        $caseTypes = CaseModel::select('case_type')
            ->distinct()
            ->whereNotNull('case_type')
            ->orderBy('case_type')
            ->get()
            ->map(function($case) {
                return (object)['name' => $case->case_type];
            });
        
        return view('schedule.index', compact(
            'totalCases',
            'inProgressCases',
            'completedCases',
            'caseTypes',
            'locations'
        ));
    }

    public function getCasesData(Request $request)
    {
        $query = CaseModel::with(['customer', 'creator', 'completer']);
        
        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Apply case type filter
        if ($request->filled('case_type')) {
            $query->where('case_type', $request->case_type);
        }
        
        // Apply date range filter
        if ($request->filled('min_date')) {
            $query->whereDate('created_at', '>=', $request->min_date);
        }
        
        if ($request->filled('max_date')) {
            $query->whereDate('created_at', '<=', $request->max_date);
        }
        
        return DataTables::of($query)
            ->addColumn('customer_name', function($case) {
                return $case->customer ? $case->customer->customer_name : '---';
            })
            ->addColumn('creator_name', function($case) {
                return $case->creator ? $case->creator->name : '---';
            })
            ->addColumn('completer_name', function($case) {
                return $case->completer ? $case->completer->name : '---';
            })
            ->editColumn('created_at', function($case) {
                return $case->created_at ? $case->created_at->format('Y-m-d H:i:s') : '';
            })
            ->editColumn('deadline', function($case) {
                return $case->deadline ? $case->deadline->format('Y-m-d') : null;
            })
            ->rawColumns(['customer_name', 'creator_name', 'completer_name'])
            ->make(true);
    }
    
    
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'case_type'   => 'required|string|max:255',
                'customer_id' => 'required|exists:register,customer_id',
                'status'      => 'required|in:Open,Pending,In Progress,Completed',
                'deadline'    => 'nullable|date|after_or_equal:today',
                'remark'      => 'nullable|string',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors'  => $validator->errors()
                ], 422);
            }
    
            $case = CaseModel::create([
                'case_type'       => $request->case_type,
                'customer_id'     => $request->customer_id,
                'status'           => $request->status,
                'create_date'      => now(),
                'deadline'         => $request->deadline,
                'remark'           => $request->remark,
                'created_by'        => optional(Auth::user())->name ?? ($request->created_by ?? 'API User'),
                'update_attempts'  => 0,
            ]);
    
            $case->load(['customer']);
    
            return response()->json([
                'success' => true,
                'message' => 'Case created successfully',
                'data'    => $case
            ], 201);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create case',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function SchNewRegister()
    {

        $locations = Location::where('status', 1)->get();
        $tariffs = Tariff::where('status', '1')->get(); 

        return view('schedule.sch_new_register', compact('locations', 'tariffs'));
    }

    public function schNewRegisterData(Request $request)
    {
        $today = Carbon::today(); // uses app timezone

        $q = Register::query()
            ->where('status', 'Pending')
            ->whereDate('first_start_date', '>', $today);

        // Optional: apply existing filters you still want to allow
        if ($request->filled('location')) {
            $q->where('province', $request->location);
        }
        if ($request->filled('tariff')) {
            $q->where('tariff_name', $request->tariff); // adjust if joined
        }

        // Optional: column-specific search like your existing API
        if ($request->filled('column_index') && $request->filled('column_search')) {
            $map = [
                0 => 'customer_id',
                1 => 'customer_name',
                2 => 'pppoe',
                3 => 'router',
                4 => 'remark',
                5 => 'province',
                7 => 'agent',
                9 => 'status',
            ];

            $col = $map[(int)$request->column_index] ?? null;
            if ($col) {
                $q->where($col, 'like', '%'.$request->column_search.'%');
            }
        }

        // If you still show “activeCount” on this page, decide what it means.
        // For this endpoint it will always be 0 (because only Pending).
        $activeCount = 0;

        return DataTables::of($q)
            ->addColumn('tariff_bandwidth', function ($row) {
                return ($row->tariff_name ?? '---') . ' ' . ($row->bandwidth ?? '---');
            })
            ->with(['activeCount' => $activeCount])
            ->make(true);
    }

    public function completeNewRegister($customer_id)
    {
        $today = now()->toDateString();

        $info = Register::where('customer_id', $customer_id)->firstOrFail();

        $info->update([
            'status'         => 'Active',
            'complete_date' => now(),
        ]);

        return back()->with('success', 'Completed! Customer is now Active.');

    }

    public function deleteSchNewRegister($id)
    {
        try {
            $register = Register::findOrFail($id);

            if ($register->status !== 'Pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only Pending registrations can be deleted.'
                ], 400);
            }

            $register->delete();

            return response()->json([
                'success' => true,
                'message' => 'Registration deleted successfully.'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete registration.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
