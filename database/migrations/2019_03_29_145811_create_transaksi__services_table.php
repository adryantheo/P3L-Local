<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksiServicesTable extends Migration
{
   
    public function up()
    {
        Schema::create('transaksi__services', function (Blueprint $table) {
            $table->increments('id');
            $table->double('Total_Biaya');
            $table->integer('Jumlah_Service');
            $table->string('Status');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('transaksi_id');
            $table->unsignedInteger('service_id');
            $table->unsignedInteger('kendaraan_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi__services');
    }
}
