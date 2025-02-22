<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopupsTable extends Migration
{
    public function up()
    {
        Schema::create('topups', function (Blueprint $table) {
            $table->id();
            $table->integer('pengepul_id');
            $table->integer('jumlah');
            $table->string('metode')->nullable();
            $table->string('status')->default('pending');
            $table->string('bukti_pembayaran')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('topups');
    }
}
