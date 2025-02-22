<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Membuat user Admin
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'nomor_telp' => '088218476621',
            'role' => 'admin',
            'password' => bcrypt('1'),
            'saldo' => 25000,
        ]);


        $this->call([
            NasabahSeeder::class,
            PengepulSeeder::class,
            SampahSeeder::class,
  

        ]);
    }
}
