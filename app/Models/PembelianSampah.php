<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PembelianSampah extends Model
{
  use HasFactory;

  protected $fillable = [
    'pengepul_id', 'penyetoran_sampah_id', 'harga_pembelian', 'jumlah'
  ];

  public function pengepul(): BelongsTo
  {
    return $this->belongsTo(Pengepul::class);
  }

  public function penyetoranSampah(): BelongsTo
  {
    return $this->belongsTo(PenyetoranSampah::class);
  }
}