<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Lokasi;
use App\Models\Barang;

class AdminController extends Controller
{
    public function index () {
        return view ('page.index');
    }


    public function show(Request $request)
    {

        $dataList = BarangMasuk::all();
        $barang = BarangMasuk::all();
        $barangMasuk = BarangMasuk::all();
        $lokasiId = $request->query('lokasi_id');

        $lokasi = Lokasi::all();
        $startOfYear = Carbon::now()->subMonths(11)->startOfMonth(); 
        $endOfYear = Carbon::now()->endOfMonth();

        $barangMasukPerBulan = BarangMasuk::selectRaw('
        YEAR(created_at) as tahun,
        MONTH(created_at) as bulan_angka,
        MONTHNAME(created_at) as bulan,
        COUNT(*) as jumlah
    ')
    ->whereBetween('created_at', [$startOfYear, $endOfYear])
    ->groupBy('tahun', 'bulan_angka', 'bulan')
    ->orderBy('tahun')
    ->orderBy('bulan_angka')
    ->get();


 
        $labels = [];
        $data = [];

        for ($i = 0; $i < 12; $i++) {
    $date = $startOfYear->copy()->addMonths($i);

    $labels[] = $date->format('F'); // Nama bulan untuk chart
    $bulanAngka = $date->month;     // 1–12

    $jumlah = $barangMasukPerBulan
        ->firstWhere('bulan_angka', $bulanAngka)
        ->jumlah ?? 0;

    $data[] = $jumlah;
}

        return view('page.index', compact('dataList', 'labels', 'data', 'lokasi','barangMasuk', 'barang'));
    }
    
}
