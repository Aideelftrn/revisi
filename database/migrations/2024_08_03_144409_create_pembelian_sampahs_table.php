<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelianSampahsTable extends Migration
{
    public function up(): void
    {
        Schema::create('pembelian_sampahs', function (Blueprint $table) {
            $table->id();
            $table->integer('pengepul_id');
            $table->integer('penyetoran_sampah_id');
            $table->integer('harga_pembelian');
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembelian_sampahs');
    }
}
