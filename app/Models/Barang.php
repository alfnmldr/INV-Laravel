<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lokasi;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang_masuk';

    protected $fillable = [
    'kode_barang',
    'nama_barang',
    'tgl_insert',
    'foto',
    'jumlah',
    'sumber',
    'nama_lokasi',
    'id_lokasi',
    ];

    public $timestamps = false;

    public function lokasi()
{
    return $this->belongsTo(Lokasi::class, 'id_lokasi');
}
public function id()
    {
        return $this->belongsTo(BarangMasuk::class, 'id');
    }
}