<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenarikansTable extends Migration
{
    public function up()
    {
        Schema::create('penarikans', function (Blueprint $table) {
            $table->id();
            $table->integer('nasabah_id');
            $table->integer('jumlah');
            $table->string('tujuan');
            $table->string('bukti_pembayaran')->nullable(); 
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->foreign('nasabah_id')->references('id')->on('nasabahs')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('penarikans');
    }
}
