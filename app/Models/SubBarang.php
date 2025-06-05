<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubBarang extends Model
{
    use HasFactory;

    protected $table = 'sub_barang';

    protected $fillable = ['kd_sub_barang', 'id_lokasi'];

    public $timestamps = false;

    public function barangMasuk()
    {
        return $this->belongsTo(BarangMasuk::class, 'id');
    }
}
