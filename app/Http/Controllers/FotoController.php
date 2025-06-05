<?php

namespace App\Http\Controllers;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FotoController extends Controller
{
    public function index() 
    {
        $fotos = DB::Table('barang_masuk')
                ->select('nama_barang', 'foto')
                ->get();

                return view('page.foto', compact('fotos'));
    }

    
}
