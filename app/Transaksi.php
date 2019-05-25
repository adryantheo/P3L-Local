<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'Total_Pembelian', 
        'Total_Service',
        'Total_Seluruh',
        'Diskon',
        'Tanggal',
        'Status',
        'cabang_id',
        'kustomer_id',
        'user_id',
        'nama_cs',
        'is_paid'
        
 ];

     public function cabang(){
        return $this->belongsTo(Cabang::class, 'cabang_id');
    }

    public function transaksi_service(){
        return $this->hasMany(Transaksi_Service::class);
    }

    public function transaksi_sparepart(){
        return $this->hasMany(Transaksi_Sparepart::class);
    }

    public function pegawai(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kustomer(){
        return $this->belongsTo(Kustomer::class, 'kustomer_id');
    }
}
