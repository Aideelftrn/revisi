<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sampah;

class SampahSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // Menambahkan data sampah
    Sampah::create([
      'jenis_sampah' => 'Plastik',
      'nama_sampah' => 'Botol Plastik',
      'berat' => 1.00,
      'harga_jual' => 6000,
    ]);

    Sampah::create([
      'jenis_sampah' => 'Kertas',
      'nama_sampah' => 'Kertas Bekas',
      'berat' => 0.50,
      'harga_jual' => 2500,
    ]);
  }
}
