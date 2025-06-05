<?php

namespace App\Http\Controllers;
use App\Models\Lokasi;

use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'nama_lokasi' => 'required|max:255',
        ]);

        Lokasi::create([
            'nama_lokasi' => $request->nama_lokasi,
        ]);

        return redirect()->back()->with('success' ,'Lokasi sukses ditambahkan!');
    }
    public function destroy($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        $lokasi->delete();

        return redirect()->back()->with('success', 'Lokasi berhasil dihapus!');
    }

}
