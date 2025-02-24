<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sampah extends Model
{
    protected $fillable = [
        'jenis_sampah',
        'nama_sampah',
        'berat',
        'harga_jual'
    ];

    public function PenyetoranSampahs()
    {
        return $this->hasMany(PenyetoranSampah::class);
    }

    public static function jenisSampahOptions()
    {
        return [
            'Organik' => 'Organik',
            'Anorganik' => 'Anorganik',
            'B3' => 'B3',
        ];
    }
}
