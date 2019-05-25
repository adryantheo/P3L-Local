<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'Nama_Service', 
        'Tarif', 
        
 ];

 public function transaksi_service()
 {
     return $this->hasMany(Transaksi_Service::class);
 }

}
