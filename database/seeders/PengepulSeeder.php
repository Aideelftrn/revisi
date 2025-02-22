<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\User; // Import model User
use App\Models\Pengepul; // Import model Pengepul
use Illuminate\Support\Facades\Hash;

class PengepulSeeder extends Seeder
{
    public function run()
    {
        // Simpan data Pengepul
        $pengepul = Pengepul::create([
            'id' => 1,
            'user_id' => 3,
            'kode_pengepul' => 'P0001',
            'nama_pengepul' => 'Pengepul-1',
            'jenis_kelamin' => 'Laki-Laki',
            'email' => 'pengepul@gmail.com',
            'nomor_telp' => '123123123',
            'alamat' => 'Jl. Pasirjati',
            'umur' => 22,
            'nik' => '123123123',
            'saldo' => 1000000, // Set initial saldo
            'role' => 'pengepul',
            'password' => bcrypt('1'),
        ]);

        User::create([
            'id' => 3,
            'name' => $pengepul->nama_pengepul,
            'email' => $pengepul->email,
            'nomor_telp' => $pengepul->nomor_telp,
            'role' => 'pengepul',
            'password' => Hash::make('1'),
        ]);
    }
}
