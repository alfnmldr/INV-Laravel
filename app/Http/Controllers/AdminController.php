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

        $barangMasukPerBulan = BarangMasuk::selectRaw('MONTHNAME(created_at) as bulan, YEAR(created_at) as tahun, COUNT(*) as jumlah')
            ->whereBetween('created_at', [$startOfYear, $endOfYear])
            ->groupBy('bulan', 'tahun')
            ->orderByRaw('YEAR(created_at), MONTH(created_at)')
            ->get()
            ->pluck('jumlah', 'bulan');

 
        $labels = [];
        $data = [];

        for ($i = 0; $i < 12; $i++) {
            $month = $startOfYear->copy()->addMonths($i)->format('F'); 
            $labels[] = $month;
            $data[] = $barangMasukPerBulan->get($month, 0);
        }
        return view('page.index', compact('dataList', 'labels', 'data', 'lokasi','barangMasuk', 'barang'));
    }
    
}
