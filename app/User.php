<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, SoftDeletes;

    protected $fillable = [
        'Nama',
        'email',
        'Alamat',
        'Gaji',
        'Role',
        'password',
    ];

    
    protected $hidden = [
        'password', 'remember_token',
    ];

    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function transaksi_services(){
        return $this->hasMany(Transaksi_Service::class);
    }

    public function transaksi_spareparts(){
        return $this->hasMany(Transaksi_Service::class);
    }

    public function transaksis(){
        return $this->hasMany(transaksis::class);
    }
}
