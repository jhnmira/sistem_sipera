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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang');
            $table->string('nup');
            $table->string('nama');
            $table->string('merek')->nullable();
            $table->string('nomor_seri')->nullable();
            $table->string('lokasi');
            $table->string('kondisi');
            $table->date('tanggal_servis_terakhir')->nullable();
            $table->integer('interval_servis');
            $table->date('tanggal_servis_selanjutnya')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
