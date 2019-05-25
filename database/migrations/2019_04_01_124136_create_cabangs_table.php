<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCabangsTable extends Migration
{
    public function up()
    {
        Schema::create('cabangs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Nama_Cabang');
            $table->string('Alamat_Cabang');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cabangs');
    }
}
