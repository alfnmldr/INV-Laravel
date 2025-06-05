<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;
use App\Models\SubBarang;
use App\Models\Lokasi;

class BarangController extends Controller
{
    public function show() {
        $dataList = Barang::all();
        return view('page.index', ['dataList' => $dataList]);
    }

    public function index()
    {
        $barangMasuk = DB::table('barang_masuk')
            ->selectRaw('MONTHNAME(created_at) as bulan, COUNT(*) as jumlah')
            ->groupBy('bulan')
            ->pluck('jumlah', 'bulan');

        $labels = $barangMasuk->keys()->toArray(); 
        $data = $barangMasuk->values()->toArray();

        session(['labels' => $labels, 'data' => $data]);

        return view('page.index', compact('labels', 'data'));
    }

    public function anotherView()
    {
        $labels = session('labels');
        $data = session('data');

        return view('manajer.dashboard', compact('labels', 'data'));
    }


public function store(Request $request)
{
    $validateData = $request->validate([
        'kode_barang' => 'required|string|max:255',
        'nama_barang' => 'required|string|max:255',
        'tgl_insert' => 'required|date',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'jumlah' => 'required|integer|min:1',
        'sumber' => 'required|in:Beli,Hibah',
        'id_lokasi' => 'required|exists:lokasi,id_lokasi',
        'kondisi' => 'required|in:Baik,Rusak',
    ]);

    // Cek apakah barang dengan kode_barang atau nama_barang sudah ada
    $existingBarang = BarangMasuk::where('kode_barang', $request->kode_barang)
        ->orWhere('nama_barang', $request->nama_barang)
        ->first();

    if ($existingBarang) {
        return redirect()->back()->withErrors(['error' => 'Barang dengan kode atau nama tersebut sudah ada di database.']);
    }

    // Proses upload foto jika ada
    if ($request->hasFile('foto')) {
        $fileName = time() . '.' . $request->foto->extension();
        $request->foto->move(public_path('uploads'), $fileName);
        $validateData['foto'] = $fileName;
    }

    // Simpan data barang masuk dengan status 'Request'
    $barangMasuk = BarangMasuk::create([
        'kode_barang' => $request->kode_barang,
        'nama_barang' => $request->nama_barang,
        'tgl_insert' => $request->tgl_insert,
        'foto' => $validateData['foto'] ?? null,
        'jumlah' => $request->jumlah,
        'sumber' => $request->sumber,
        'id_lokasi' => $request->id_lokasi,
        'kondisi' => $request->kondisi,
        'status' => 'Request', // Set status awal sebagai 'Request'
    ]);

    // Tambahkan data ke sub barang
    for ($i = 0; $i < $request->jumlah; $i++) {
        SubBarang::create([
            'kd_sub_barang' => $barangMasuk->id,
            'id_lokasi' => $request->id_lokasi,
        ]);
    }

    return redirect()->back()->with('success', 'Data Barang berhasil ditambahkan.');
}

public function approve($id)
{
    $barang = Barang::find($id);
    $barang->status = 'Approved';
    $barang->save();

    return redirect()->back()->with('success', 'Barang berhasil diatur untuk Approve.');
}


public function revisi($id)
{
    $barang = Barang::findOrFail($id);
    $barang->status = 'Revisi';
    $barang->save();

    return redirect()->back()->with('success', 'Barang berhasil diatur untuk direvisi.');
}




    public function update(Request $request, $id)
{
    $request->validate([
        'kode_barang' => 'required',
        'nama_barang' => 'required',
        'tgl_insert' => 'required|date',
        'jumlah' => 'required|numeric',
        'sumber' => 'required',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'kondisi' => 'required',
    ]);

    // Cari barang berdasarkan id
    $barang = Barang::findOrFail($id);

    if ($request->hasFile('foto')) {
        if ($barang->foto && file_exists(public_path('uploads/' . $barang->foto))) {
            unlink(public_path('uploads/' . $barang->foto));
        }

        $file = $request->file('foto');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $filename);

        $barang->foto = $filename;
    }

    // Update data lainnya
    $barang->kode_barang = $request->kode_barang;
    $barang->nama_barang = $request->nama_barang;
    $barang->tgl_insert = $request->tgl_insert;
    $barang->jumlah = $request->jumlah;
    $barang->sumber = $request->sumber;
    $barang->kondisi = $request->kondisi;
    $barang->id_lokasi = $request->id_lokasi;

    // Ubah status menjadi 'Pending' untuk persetujuan ulang dari manajer
    $barang->status = 'Pending';

    // Simpan perubahan
    $barang->save();

    return redirect()->route('index')->with('success', 'Data barang berhasil diupdate dan menunggu konfirmasi ulang');
}



    public function search(Request $request)
    {
        $searchQuery = $request->input('query');

        $dataList = Barang::where('kode_barang', 'LIKE', "%$searchQuery%")
                            ->orWhere('nama_barang', 'LIKE', "%$searchQuery%")
                            ->orWhere('sumber', 'LIKE', "%$searchQuery%")
                            ->get();

        // Kembalikan hasil pencarian ke view yang sama
        return view('page.index', compact('dataList'));
    }


    public function destroy($id)
    {

        DB::table('sub_barang')->where('id', $id)->delete();

        $item = Barang::where('id', $id)->firstOrFail();

        if ($item->foto) {
            $filePath = public_path('uploads/' . $item->foto);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $item->delete();

        return redirect()->back()->with('success', 'Barang berhasil dihapus.');
    }

    
    }
