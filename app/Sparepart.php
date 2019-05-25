<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sparepart extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'Kode_Sparepart',
        'Nama',
        'Tipe',
        'Merk',
        'Jenis_Motor',
        'Gambar',        
        'Harga_Jual',
        'Letak',
        'Stok',
        'Stok_Min'
    ];


    public function transaksi_spareparts(){
        return $this->hasMany(Transaksi_Sparepart::class);
    }

    public function detail_pesanans(){
        return $this->hasOne(Detail_Pesanan::class);
    }


}
