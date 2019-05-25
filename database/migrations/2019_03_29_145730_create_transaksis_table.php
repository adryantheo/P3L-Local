<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksisTable extends Migration
{
    
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->increments('id');
            $table->double('Total_Pembelian');
            $table->double('Total_Service');
            $table->double('Total_Seluruh');
            $table->double('Diskon');
            $table->unsignedInteger('user_id');
            $table->string('nama_cs');         
            $table->string('Status');
            $table->unsignedInteger('cabang_id');
            $table->unsignedInteger('kustomer_id');
            $table->boolean('is_paid')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('transaksis');
    }
}
