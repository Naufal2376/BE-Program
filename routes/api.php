<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::post('/register', [AuthController::class, 'register']); // Register new user
Route::post('/login', [AuthController::class, 'login']); // Login user

// Barang Routes with Authentication Middleware
Route::middleware('auth:sanctum')->group(function () {
    Route::get('barang', [BarangController::class, 'index']); // Get all barang
    Route::post('barang', [BarangController::class, 'store']); // Create a new barang
    Route::get('barang/{id}', [BarangController::class, 'show']); // Get specific barang by ID
    Route::put('barang/{id}', [BarangController::class, 'update']); // Update a specific barang by ID
    Route::delete('barang/{id}', [BarangController::class, 'destroy']); // Delete a specific barang by ID
});