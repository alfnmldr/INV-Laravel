<?php

namespace App\Http\Controllers;
use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\Lokasi;
use App\Models\User;

class ManajerController extends Controller


{
    public function getBarangMasuk()
    {
        $data = BarangMasuk::select('id', 'kode_barang', 'nama_barang', 'tgl_insert', 'foto', 'jumlah', 'sumber', 'id_lokasi')->get();

        return response()->json($data);
    }


public function index(Request $request, $id = null) {

    
    $lokasiId = $request->query('lokasi_id');
    
    $lokasi = Lokasi::all();

    if ($id === null) {
        $barangList = Barang::all();
        $userList = User::count();
        $jumlahBarang = BarangMasuk::count();
        $lokasiList = Lokasi::count();
        $showLokasi = Lokasi::all();
       $userListShow = User::all();
        return view('manajer.dashboard', compact('barangList', 'jumlahBarang', 'userList', 'lokasiList', 'lokasi', 'userListShow', 'showLokasi'));
    }
   
    $barang = Barang::find($id);

    if (!$barang) {
        return redirect()->back()->with('error', 'Barang tidak ditemukan.');
    }


    return view('manajer.dashboard', compact('barang'));
}

}
