<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function nasabah(): BelongsTo
    {
        return $this->belongsTo(Nasabah::class, 'nasabah_id');
    }

    public function pengepul()
    {
        return $this->belongsTo(Pengepul::class, 'pengepul_id');
    }

    public function penyetoranSampah(): BelongsTo
    {
        return $this->belongsTo(PenyetoranSampah::class, 'penyetoran_sampah_id');
    }
}
