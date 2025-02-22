<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nasabah extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'kode_nasabah',
        'nama_nasabah',
        'jenis_kelamin',
        'email',
        'nomor_telp',
        'alamat',
        'password',
        'umur',
        'nik',
        'saldo',
        'role',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
