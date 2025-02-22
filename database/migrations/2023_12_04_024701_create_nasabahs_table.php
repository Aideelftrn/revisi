<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nasabahs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id');
            $table->string('kode_nasabah');
            $table->string('nama_nasabah');
            $table->string('jenis_kelamin');
            $table->string('email')->nullable();
            $table->string('nomor_telp')->nullable();
            $table->string('alamat');
            $table->string('password')->nullable();
            $table->integer('umur')->nullable();
            $table->string('nik')->unique()->nullable();
            $table->string('role')->default('nasabah');
            $table->integer('saldo')->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nasabahs');
    }
};
