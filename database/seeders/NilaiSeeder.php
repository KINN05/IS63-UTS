<?php
// database/seeders/NilaiSeeder.php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\Nilai;
use Illuminate\Database\Seeder;

class NilaiSeeder extends Seeder
{
    public function run(): void
    {
        if (Siswa::count() === 0) {
            $this->command->warn('SiswaSeeder harus dijalankan lebih dulu!');
            return;
        }

        // Setiap siswa mendapat 4-6 nilai mata pelajaran
        Siswa::all()->each(function ($siswa) {
            $jumlah = rand(4, 6);
            Nilai::factory($jumlah)->create([
                'siswa_id' => $siswa->id,
            ]);
        });

        $this->command->info('NilaiSeeder: ' . Nilai::count() . ' data nilai berhasil dibuat.');
    }
}
