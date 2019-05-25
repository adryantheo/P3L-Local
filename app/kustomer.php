<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class kustomer extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'Nama_Kustomer',
        'Alamat_Kustomer',
        'Telepon_Kustomer'
    ];

    public function kendaraans()
        {
            return $this->hasMany(Kendaraan::class);
        }

    public function transaksi(){
        return $this->hasMany(Transaksi::class);
    }

}
