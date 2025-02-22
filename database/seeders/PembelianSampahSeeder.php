<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PenyetoranSampah;
use App\Models\Pengepul;
use App\Models\PembelianSampah;

class PembelianSampahSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // Membuat data dummy untuk PenyetoranSampah
    $penyetoranSampah = PenyetoranSampah::create([
      'nasabah_id' => 1,
      'sampah_id' => 1,
      'berat' => 10.00,
      'total_harga' => 50000,
    ]);
  }
}
