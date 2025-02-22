<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penarikan extends Model
{
    use HasFactory;

    protected $fillable = ['nasabah_id', 'jumlah', 'tujuan', 'status', 'bukti_pembayaran'];

    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }
}
