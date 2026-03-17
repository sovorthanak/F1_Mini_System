<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\CaseModel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CaseHandleAPIController extends Controller
{
    
    public function index(Request $request)
    {
        try {
            $query = CaseModel::with(['customer']);
            
            // Apply filters if provided
            if ($request->has('status') && !empty($request->status)) {
                $query->where('status', $request->status);
            }
            
            if ($request->has('case_type') && !empty($request->case_type)) {
                $query->where('case_type', $request->case_type);
            }
            
            if ($request->has('customer_id') && !empty($request->customer_id)) {
                $query->where('customer_id', $request->customer_id);
            }
            
            // Date range filters
            if ($request->has('start_date') && !empty($request->start_date)) {
                $query->whereDate('create_date', '>=', $request->start_date);
            }
            
            if ($request->has('end_date') && !empty($request->end_date)) {
                $query->whereDate('create_date', '<=', $request->end_date);
            }
            
            // Deadline filters
            if ($request->has('deadline_from') && !empty($request->deadline_from)) {
                $query->whereDate('deadline', '>=', $request->deadline_from);
            }
            
            if ($request->has('deadline_to') && !empty($request->deadline_to)) {
                $query->whereDate('deadline', '<=', $request->deadline_to);
            }
            
            // Search by customer name or case ID
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('case_id', 'like', "%{$search}%")
                      ->orWhere('remark', 'like', "%{$search}%")
                      ->orWhereHas('customer', function($customerQuery) use ($search) {
                          $customerQuery->where('customer_name', 'like', "%{$search}%");
                      });
                });
            }
            
            // Sorting
            $sortBy = $request->get('sort_by', 'create_date');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);
            
            // Pagination
            $perPage = $request->get('per_page', 15);
            
            if ($request->has('paginate') && $request->paginate === 'false') {
                // Return all results without pagination
                $cases = $query->get();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Cases retrieved successfully',
                    'data'    => $cases,
                    'total'   => $cases->count()
                ], 200);
            } else {
                // Return paginated results
                $cases = $query->paginate($perPage);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Cases retrieved successfully',
                    'data'    => $cases->items(),
                    'meta'    => [
                        'current_page' => $cases->currentPage(),
                        'last_page'    => $cases->lastPage(),
                        'per_page'     => $cases->perPage(),
                        'total'        => $cases->total(),
                        'from'         => $cases->firstItem(),
                        'to'           => $cases->lastItem(),
                    ]
                ], 200);
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve cases',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
    
    public function show($id)
    {
        try {
            $case = CaseModel::with(['customer'])->find($id);
            
            if (!$case) {
                return response()->json([
                    'success' => false,
                    'message' => 'Case not found'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Case retrieved successfully',
                'data'    => $case
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve case',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
    
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'case_type'   => 'required|string|max:255',
                'customer_id' => 'required|exists:customers_info,customer_id',
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
}