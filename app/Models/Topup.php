<?php

// app/Models/Topup.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topup extends Model
{
  use HasFactory;

  protected $fillable = [
    'pengepul_id',
    'jumlah',
    'metode',
    'status',
    'bukti_pembayaran'

  ];

  public function pengepul()
  {
    return $this->belongsTo(Pengepul::class);
  }
}
