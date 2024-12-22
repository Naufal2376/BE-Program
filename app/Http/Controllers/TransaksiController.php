<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        if (auth('sanctum')->user()->role === 'admin') {
            $transaksi = Transaksi::with(['barang', 'user'])->get();
        } else {
            $transaksi = Transaksi::with(['barang', 'user'])
                ->where('user_id', auth('sanctum')->id())
                ->get();
        }

        return response()->json($transaksi);
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1'
        ]);

        try {
            DB::beginTransaction();

            $barang = Barang::findOrFail($request->barang_id);

            if ($barang->stok < $request->jumlah) {
                throw new \Exception("Stok tidak mencukupi untuk barang: {$barang->nama_barang}");
            }

            $totalHarga = $barang->harga * $request->jumlah;

            $transaksi = Transaksi::create([
                'user_id' => auth('sanctum')->id(),
                'barang_id' => $request->barang_id,
                'jumlah' => $request->jumlah,
                'total_harga' => $totalHarga,
                'status' => 'proses'
            ]);

            $barang->decrement('stok', $request->jumlah);

            DB::commit();

            return response()->json([
                'message' => 'Transaksi berhasil dibuat',
                'data' => $transaksi->load(['barang', 'user'])
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Transaksi gagal',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function show($id)
    {
        if (auth('sanctum')->user()->role === 'admin') {
            $transaksi = Transaksi::with(['barang', 'user'])
                ->findOrFail($id);
        } else {
            $transaksi = Transaksi::with(['barang', 'user'])
                ->where('user_id', auth('sanctum')->id())
                ->findOrFail($id);
        }

        return response()->json($transaksi);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:proses,selesai,batal'
        ]);

        if (auth('sanctum')->user()->role === 'admin') {
            $transaksi = Transaksi::findOrFail($id);
        } else {
            $transaksi = Transaksi::where('user_id', auth('sanctum')->id())
                ->findOrFail($id);
        }

        $transaksi->update([
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'Status transaksi berhasil diupdate',
            'data' => $transaksi
        ]);
    }

    public function destroy($id)
    {
        if (auth('sanctum')->user()->role === 'admin') {
            $transaksi = Transaksi::findOrFail($id);
        } else {
            $transaksi = Transaksi::where('user_id', auth('sanctum')->id())
                ->findOrFail($id);
        }

        if ($transaksi->status === 'proses') {
            $transaksi->barang->increment('stok', $transaksi->jumlah);
        }

        $transaksi->delete();

        return response()->json([
            'message' => 'Transaksi berhasil dihapus'
        ]);
    }
}