<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('barang_keluar', function (Blueprint $table) {
        $table->id('id_barangkeluar'); // Primary Key sesuai ERD
        // Ini relasi ke tabel barang_masuk
        $table->foreignId('id')->constrained('barang_masuk')->onDelete('cascade');
        $table->date('tgl_keluar');
        $table->integer('jumlah');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_keluar');
    }
};
