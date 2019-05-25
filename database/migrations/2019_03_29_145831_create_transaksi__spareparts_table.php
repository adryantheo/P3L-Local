<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksiSparepartsTable extends Migration
{
    
    public function up()
    {
        Schema::create('transaksi__spareparts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Jumlah_Dibeli');
            $table->double('Subtotal');
            $table->integer('Sisa_Stok');
            $table->unsignedInteger('transaksi_id');
            $table->unsignedInteger('sparepart_id');
            $table->unsignedInteger('user_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi__spareparts');
    }
}
