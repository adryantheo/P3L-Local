<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_Pesanan extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'Nama_Barang',
        'Total_Harga_Beli', 
        'Jumlah_Diterima',
        'Jumlah_Pesan',
        'Harga_Beli',
        'pesanan__barang_id',
        'sparepart_id'
 ];

    public function pesanan_barangs(){
     return $this->belongsTo(Pesanan_Barang::class, 'pesanan__barang_id');
    }

    public function spareparts(){
        return $this->belongsTo(Sparepart::class, 'sparepart_id');
    }

}
