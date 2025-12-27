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
    Schema::create('sub_barang', function (Blueprint $table) {
    $table->id();
    // Relasi ke barang_masuk
    $table->foreignId('kd_sub_barang')->constrained('barang_masuk')->onDelete('cascade');
    // Relasi ke lokasi (karena pk-nya id_lokasi, harus ditulis manual)
    $table->foreignId('id_lokasi')->constrained('lokasi', 'id_lokasi')->onDelete('cascade');
    $table->timestamps();
});
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_barang');
    }
};
