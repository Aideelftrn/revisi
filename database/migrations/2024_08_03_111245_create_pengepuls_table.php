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
        Schema::create('pengepuls', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id');
            $table->string('kode_pengepul');
            $table->string('nama_pengepul');
            $table->string('jenis_kelamin');
            $table->string('email')->nullable();
            $table->string('nomor_telp')->nullable();
            $table->string('alamat');
            $table->string('password')->nullable();
            $table->integer('umur')->nullable();
            $table->string('nik')->unique()->nullable();
            $table->integer('saldo')->default(0); 
            $table->string('role')->default('pengepul');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengepuls');
    }
};

