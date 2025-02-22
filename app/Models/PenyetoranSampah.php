<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PenyetoranSampah extends Model
{
  protected $fillable = [
    'nasabah_id', 'sampah_id', 'berat', 'total_harga', 'status', 'created_by',
  ];

  public function nasabah()
  {
    return $this->belongsTo(Nasabah::class);
  }

  public function sampah()
  {
    return $this->belongsTo(Sampah::class);
  }
}
