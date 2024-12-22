<?php
namespace App\Http\Controllers;

use App\Models\Barang;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return response()->json(['status' => 'success', 'data' => $barang], 200);
    }

    public function store(Request $request)
    {
        if (Auth::user()->isPenjual || Auth::user()->isAdmin) {
            $request->validate([
                'nama_barang' => 'required|string|max:255',
                'harga' => 'required|numeric',
                'stok' => 'required|numeric',
            ]);

            $data = [
                'nama_barang' => $request->nama_barang,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'id_penjual' => auth('sanctum')->id()
            ];

            $barang = Barang::create($data);
            return response()->json(['status' => 'success', 'data' => $barang], 201);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }

    public function show($id)
    {
        try {
            $barang = Barang::findOrFail($id);
            return response()->json(['status' => 'success', 'data' => $barang], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Barang tidak ditemukan'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $barang = Barang::findOrFail($id);

            if (auth('sanctum')->user()->role === 'penjual' &&
                $barang->id_penjual !== auth('sanctum')->id()) {
                return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
            }

            // Validasi input
            $data = $request->validate([
                'nama_barang' => 'required|string|max:255',
                'harga' => 'required|numeric',
                'stok' => 'required|numeric',
            ]);

            $barang->update($data);

            return response()->json(['status' => 'success', 'data' => $barang], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Barang tidak ditemukan'], 404);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan saat memperbarui barang'], 500);
        }
    }


    public function destroy($id)
    {
        try {
            $barang = Barang::findOrFail($id);

            if (auth('sanctum')->user()->role === 'penjual' &&
                $barang->id_penjual !== auth('sanctum')->id()) {
                return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
            }

            $barang->delete();

            return response()->json(['status' => 'success', 'message' => 'Barang telah dihapus'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Barang tidak ditemukan'], 404);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan saat menghapus barang'], 500);
        }
    }

}