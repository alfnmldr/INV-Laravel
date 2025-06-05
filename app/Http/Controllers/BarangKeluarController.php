<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Barang;
Use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

// Controller
class BarangKeluarController extends Controller
{
    
public function index()
    {
        
        $barangMasuk = BarangMasuk::all();

        return view('page.index', compact('barangMasuk'));
    }

    public function show()
    {
        $barangKeluar = BarangKeluar::with('barang')->get();

        return view('page.barang-out', compact('barangKeluar'));
    }

public function store(Request $request, $approve = false)
{

    // Proses untuk menambahkan barang keluar
    // Validasi input
    $validated = $request->validate([
        'id' => 'required|exists:barang_masuk,id',
        'jumlah' => 'required|integer|min:1',
        'tgl_keluar' => 'required|date',
    ]);

    // Temukan barang berdasarkan ID
    $barang = BarangMasuk::findOrFail($validated['id']);

    // Cek jika stok cukup
    if ($barang->jumlah < $validated['jumlah']) {
        return response()->json(['error' => 'Stok barang tidak mencukupi!'], 400);
    }

    // Kurangi stok barang yang ada
    $barang->jumlah -= $validated['jumlah'];
    $barang->save();

    // Cek apakah data sudah ada di tabel BarangKeluar
    $barangKeluar = BarangKeluar::where('id', $validated['id'])->first();

    if ($barangKeluar) {
        // Update jumlah jika data sudah ada
        $barangKeluar->tgl_keluar = $validated['tgl_keluar'];
        $barangKeluar->jumlah += $validated['jumlah'];
        $barangKeluar->update();
    } else {
        BarangKeluar::create([
            'id' => $validated['id'],
            'tgl_keluar' => $validated['tgl_keluar'],
            'jumlah' => $validated['jumlah'],
            'status' => 'pending', // Atur status awal sebagai pending
        ]);
    }

    return response()->json(['success' => 'Barang Keluar sukses ditambahkan!']);
}

public function updateStatus(Request $request)
{
    $validated = $request->validate([
        'barang_id' => 'required|exists:barang_keluar,id_barangkeluar',
        'status' => 'required|in:approve,reject', // Validasi agar hanya menerima nilai enum yang valid
    ]);

    $barang = BarangKeluar::findOrFail($request->barang_id);
    $barang->status = $request->status;
    $barang->save();

    return response()->json(['success' => true, 'message' => 'Status berhasil diperbarui']);
}




public function cetakReport(Request $request)
{
    $range = $request->input('range');
    $barangKeluar = BarangKeluar::query();

    if ($range === 'Per Minggu') {

        $barangKeluar->whereBetween('tgl_keluar', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
    } elseif ($range === 'Bulanan') {

        $barangKeluar->whereMonth('tgl_keluar', Carbon::now()->month);
    }

    $barangKeluar = $barangKeluar->get();

    return view('page.barang-out-print', compact('barangKeluar', 'range'));
}



}
