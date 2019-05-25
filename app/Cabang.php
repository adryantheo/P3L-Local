<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cabang extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'Nama_Cabang',
        'Alamat_Cabang',
    ];

    public function transaksi(){
        return $this->hasMany(Transaksi::class);
    }
}
