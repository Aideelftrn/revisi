<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaksi;
use App\Models\Nasabah;

class TransaksiSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // Ambil data dummy
    $nasabah = Nasabah::first();

    // Simpan data transaksi
    Transaksi::create([
      'kode_transaksi' => 'TRX-' . uniqid(),
      'nasabah_id' => $nasabah->id,
      'jumlah' => 10000,
      'tanggal_transaksi' => now(),
    ]);
  }
}
