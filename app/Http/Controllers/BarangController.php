<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller {
    public function index() {
        return Barang::all();
    }

    public function store(Request $request) {
        $data = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);

        $Barang = Barang::create([
            'nama_barang' => $data['nama_barang'],
            'harga' => $data['harga'],
            'stok' => $data['stok'],
            'id_penjual' => auth('sanctum')->id(),
        ]);

        return response()->json($Barang, 201);
    }

    public function show($id) {
        return Barang::findOrFail($id);
    }

    public function update(Request $request, $id) {
        $Barang = Barang::findOrFail($id);

        $data = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);

        $Barang->update($data);
        return response()->json($Barang, 200);
    }


    public function destroy($id) {
        $Barang = Barang::findOrFail($id);
        $Barang->delete();
        return response()->json(['message' => 'Barang telah dihapus'], 200);
    }
}