<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Import model User
use App\Models\Nasabah; // Import model Nasabah
use Illuminate\Support\Facades\Hash;

class NasabahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Simpan data Nasabah
        $nasabah = Nasabah::create([
            'id' => 1,
            'user_id' => 2,
            'kode_nasabah' => 'N0001',
            'nama_nasabah' => 'Nasabah-1',
            'jenis_kelamin' => 'Laki-Laki',
            'email' => 'nasabah@gmail.com',
            'nomor_telp' => '088218476623',
            'alamat' => 'Jl. Pasirjati',
            'umur' => 22,
            'nik' => '3213012312',
            'role' => 'nasabah',
            'saldo' => 1000000,
            'password' => bcrypt('1'),
        ]);

        User::create([
            'id' => 2,
            'name' => $nasabah->nama_nasabah,
            'email' => $nasabah->email,
            'nomor_telp' => $nasabah->nomor_telp,
            'role' => 'nasabah',
            'password' => Hash::make('1'),
        ]);
    }
}
