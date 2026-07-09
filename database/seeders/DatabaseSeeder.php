<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Urutan ini WAJIB diikuti karena adanya foreign key:
        // 1. Kelas dulu (tidak bergantung pada tabel lain)
        // 2. Siswa (bergantung pada kelas)
        // 3. Nilai (bergantung pada siswas)
        $this->call([
            UserSeeder::class,        // <- PERTAMA, tidak bergantung tabel lain
            KelasSeeder::class,
            SiswaSeeder::class,
            NilaiSeeder::class,
        ]);
    }
}
