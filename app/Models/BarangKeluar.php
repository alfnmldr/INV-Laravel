<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lokasi;

class BarangKeluar extends Model
{
    use HasFactory;
    protected $table = 'barang_keluar';
    protected $fillable = ['id', 'tgl_keluar', 'jumlah'];

    public $timestamps = false;
public function barang()
{
    return $this->belongsTo(BarangMasuk::class, 'id', 'id');
}
}

