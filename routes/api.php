<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('barang', [BarangController::class, 'index']);
    Route::get('barang/{id}', [BarangController::class, 'show']);

    Route::middleware('role:user')->group(function () {
        Route::get('transaksi', [TransaksiController::class, 'index']);
        Route::post('transaksi', [TransaksiController::class, 'store']);
        Route::get('transaksi/{id}', [TransaksiController::class, 'show']);
        Route::put('transaksi/{id}/status', [TransaksiController::class, 'updateStatus']);
        Route::delete('transaksi/{id}', [TransaksiController::class, 'destroy']);
    });

    Route::middleware('role:penjual')->group(function () {
        Route::post('barang', [BarangController::class, 'store']);
        Route::put('barang/{id}', [BarangController::class, 'update']);
        Route::delete('barang/{id}', [BarangController::class, 'destroy']);
    });

    Route::middleware('role:admin')->group(function () {
        Route::post('barang', [BarangController::class, 'store']);
        Route::put('barang/{id}', [BarangController::class, 'update']);
        Route::delete('barang/{id}', [BarangController::class, 'destroy']);

        Route::get('transaksi', [TransaksiController::class, 'index']);
        Route::post('transaksi', [TransaksiController::class, 'store']);
        Route::get('transaksi/{id}', [TransaksiController::class, 'show']);
        Route::put('transaksi/{id}/status', [TransaksiController::class, 'updateStatus']);
        Route::delete('transaksi/{id}', [TransaksiController::class, 'destroy']);
    });
});

Route::fallback(function () {
    return response()->json([
        'status' => 'error',
        'message' => 'Not Found',
    ], 404);
});