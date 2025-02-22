<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    // use HasApiTokens, HasFactory, Notifiable;
    use  HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'nomor_telp',
        'password',
        'role',
        'saldo'
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


 
    public function nasabah(): HasOne
    {
        return $this->hasOne(Nasabah::class);
    }
 
    public function pengepul(): HasOne
    {
        return $this->hasOne(Pengepul::class);
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function akunBanks()
    {
        return $this->hasMany(Akun::class);
    }
}
