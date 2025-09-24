<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceController;

// Route to get the authenticated user's details
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Authentication routes 
Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register'); // Register a new user
    Route::post('/login', 'login'); // Log in a user and issue a token (sanctum)
});

// Invoice routes (protected by auth:sanctum middleware)
Route::controller(InvoiceController::class)
    ->prefix('invoices')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/', 'index'); // Get all invoices for the authenticated user
        Route::post('/', 'create'); // Create a new invoice
        Route::put('/{id}', 'update'); // Update an existing invoice by ID
        Route::delete('/{id}', 'delete'); // Delete an invoice by ID
        Route::get('/{id}', 'single'); // Get a single invoice by ID
    });
