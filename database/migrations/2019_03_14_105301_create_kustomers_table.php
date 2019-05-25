<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKustomersTable extends Migration
{
   
    public function up()
    {
        Schema::create('kustomers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Nama_Kustomer');
            $table->string('Alamat_Kustomer');
            $table->string('Telepon_Kustomer')->unique();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('kustomers');
    }
}
