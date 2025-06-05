<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\Lokasi;

class BarangMasuk extends Model
{
    use HasFactory;

    protected $table = 'barang_masuk';

    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_barang', 
        'nama_barang', 
        'tgl_insert', 
        'foto', 
        'jumlah', 
        'sumber', 
        'nama_lokasi', 
        'id_lokasi',
        'kondisi'
    ];

    public $timestamps = false;

    public function subBarang()
{
    return $this->hasMany(SubBarang::class, 'id');
}

public function lokasi()
{
    return $this->belongsTo(Lokasi::class, 'id_lokasi', 'id_lokasi');
}

   
}
