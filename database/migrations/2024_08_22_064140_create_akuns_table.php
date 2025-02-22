<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAkunsTable extends Migration
{
    public function up()
    {
        Schema::create('akuns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); 
            $table->string('jenis');
            $table->string('nomor_akun')->unique(); 
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('akuns');
    }
}
