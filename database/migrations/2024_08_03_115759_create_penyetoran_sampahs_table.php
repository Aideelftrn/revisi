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
        Schema::create('penyetoran_sampahs', function (Blueprint $table) {
            $table->id();
            $table->integer('nasabah_id')->nullable();
            $table->integer('sampah_id')->nullable();
            $table->integer('berat');
            $table->integer('total_harga');
            $table->integer('total_harga_jual')->nullable();
            $table->string('status')->default('pending');
            $table->unsignedBigInteger('created_by'); 
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyetoran_sampahs');
    }
};
