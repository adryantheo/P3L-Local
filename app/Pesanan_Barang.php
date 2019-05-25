<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pesanan_Barang extends Model
{
    use SoftDeletes;
    
    protected $fillable = [        
        'Status', 
        'Tanggal_Pesan',
        'Tanggal_Terima',
        'sales_id'
 ];

 public function sales(){
    return $this->belongsTo(Sales::class, 'sales_id');
}

public function detail_pesanans(){
    return $this->hasMany(Detail_Pesanan::class);
}
}
