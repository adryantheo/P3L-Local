<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class kendaraan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'Plat_kendaraan', 
        'Merk', 
        'Tipe',
        'kustomer_id',
    ];

    public function kustomers(){
        return $this->belongsTo(Kustomer::class, 'kustomer_id');
    }

    public function transaksi_services(){
        return $this->hasMany(Transaksi_Service::class);
    }


   
}
