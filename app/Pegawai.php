<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    use SoftDeletes, HasApiTokens;
    protected $fillable = [
        'Nama',
        'Email',
        'Alamat',
        'Gaji',
        'Role',
        'Password',
    ];

    
    protected $hidden = [
        'Password', 'remember_token',
    ];



    public function transaksi_service(){
        return $this->hasMany(Pegawai::class);
    }
}
