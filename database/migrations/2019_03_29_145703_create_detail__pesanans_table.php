<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailPesanansTable extends Migration
{
   
    public function up()
    {
        Schema::create('detail__pesanans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Nama_Barang');
            $table->double('Total_Harga_Beli');
            $table->Integer('Jumlah_Diterima');
            $table->Integer('Jumlah_Pesan');
            $table->double('Harga_Beli');
            $table->unsignedInteger('pesanan__barang_id');
            $table->unsignedInteger('sparepart_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('detail__pesanans');
    }
}
