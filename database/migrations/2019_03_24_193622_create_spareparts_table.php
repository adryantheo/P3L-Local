<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSparepartsTable extends Migration
{
    
    public function up()
    {
        Schema::create('spareparts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Kode_Sparepart')->unique();
            $table->string('Nama');
            $table->string('Tipe');
            $table->string('Merk');
            $table->string('Gambar')->nullable();
            $table->string('Jenis_Motor');
           
            $table->double('Harga_Jual');
            $table->string('Letak');
            $table->unsignedInteger('Stok');
            $table->unsignedInteger('Stok_Min');
            $table->softDeletes();
            $table->timestamps();
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('spareparts');
    }
}
