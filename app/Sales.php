<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sales extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'Nomor_Telphone_Sales',
        'Nama_Sales',
        'Nama_Supplier',
        'Alamat_Sales'
    ];

    public function pesanan_barangs(){
        return $this->hasMany(Pesanan_Barang::class);
    }

}
