<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

// Controller for handling Invoice-related CRUD operations
class InvoiceController extends Controller
{
    // Constructor to apply authentication middleware (sanctim)
    public function __construct()
    {
        $user = auth()->user();
        // To Ensures all methods require authentication
    }

    // Retrieve all invoices for the authenticated user
    public function index()
    {
        // Get the authenticated user
        $user = auth()->user();
        // Fetch all invoices for the user
        $invoices = Invoice::where('user_id', $user->id)->get();
        // Return JSON response
        return response()->json([
            'status' => 'success',
            'message' => 'Invoices retrieved successfully',
            'data' => $invoices
        ], 200);
    }

    // Create a new invoice
    public function create(Request $request)
    {
        // Validate input data
        $validator = Validator::make($request->all(), [
            'invoice_number' => 'required|string|unique:invoices,invoice_number',
            'status' => 'required|in:pending,paid,overdue',
            'due_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'data' => $validator->errors()
            ], 422);
        }

        // Get the authenticated user
        $user = auth()->user();
        // Create new invoice
        $invoice = Invoice::create([
            'user_id' => $user->id,
            'invoice_number' => $request->input('invoice_number'),
            'enum' => $request->input('status'), 
            'due_date' => $request->input('due_date'),
            'description' => $request->input('description'),
        ]);

        // Return JSON response
        return response()->json([
            'status' => 'success',
            'message' => 'Invoice created successfully',
            'data' => $invoice
        ], 201);
    }

    // Update an existing invoice
    public function update(Request $request, $id)
    {
        // Validate input data
        $validator = Validator::make($request->all(), [
            'invoice_number' => 'required|string|unique:invoices,invoice_number,' . $id,
            'status' => 'required|in:pending,paid,overdue',
            'due_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'data' => $validator->errors()
            ], 422);
        }

        // Get the authenticated user
        $user = auth()->user();
        try {
            // Find invoice, ensuring it belongs to the user
            $invoice = Invoice::where('id', $id)->where('user_id', $user->id)->firstOrFail();
            // Update invoice with validated data
            $invoice->update([
                'invoice_nunber' => $request->input('invoice_number'), 
                'enum' => $request->input('status'),
                'due_date' => $request->input('due_date'),
                'description' => $request->input('description'),
            ]);

            // Return JSON response
            return response()->json([
                'status' => 'success',
                'message' => 'Invoice updated successfully',
                'data' => $invoice
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invoice not found or unauthorized',
                'data' => null
            ], 404);
        }
    }

    // Delete an invoice
    public function delete($id)
    {
        // Get the authenticated user
        $user = auth()->user();
        try {
            // Find invoice, ensuring it belongs to the user
            $invoice = Invoice::where('id', $id)->where('user_id', $user->id)->firstOrFail();
            $invoice->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Invoice deleted successfully',
                'data' => null
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invoice not found or unauthorized',
                'data' => null
            ], 404);
        }
    }

    // Retrieve a single invoice
    public function single($id)
    {
        // Get the authenticated user
        $user = auth()->user();
        try {
            // Find invoice, ensuring it belongs to the user
            $invoice = Invoice::where('id', $id)->where('user_id', $user->id)->firstOrFail();

            // Return JSON response
            return response()->json([
                'status' => 'success',
                'message' => 'Invoice retrieved successfully',
                'data' => $invoice
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invoice not found or unauthorized',
                'data' => null
            ], 404);
        }
    }
}