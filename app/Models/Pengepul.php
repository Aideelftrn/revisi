<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Pengepul extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_pengepul',
        'nama_pengepul',
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

}
