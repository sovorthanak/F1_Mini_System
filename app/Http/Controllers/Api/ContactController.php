<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\CaseModel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:contacts,email',
        ]);

        // Create record
        $contact = Contact::create($validated);

        return response()->json([
            'message' => 'Contact created successfully.',
            'data'    => $contact
        ], 201);
    }
    
    public function storeCase(Request $request)
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

