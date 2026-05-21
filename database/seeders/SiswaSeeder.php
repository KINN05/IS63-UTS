<?php
// database/seeders/SiswaSeeder.php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan data kelas sudah ada
        if (Kelas::count() === 0) {
            $this->command->warn('KelasSeeder harus dijalankan lebih dulu!');
            return;
        }

        // Buat 30 siswa dummy menggunakan Factory
        Siswa::factory(30)->create();

        // Tambah 1 data siswa manual untuk keperluan demo
        $kelas = Kelas::where('kode_kelas', 'X-A')->first();
        Siswa::create([
            'kelas_id'    => $kelas->id,
            'nis'         => '2024001001',
            'nama'        => 'Ahmad Rizky Pratama',
            'email'       => 'ahmad.rizky@example.com',
            'tahun_masuk' => 2024,
            'status'      => 'aktif',
            'no_hp'       => '081234567890',
            'alamat'      => 'Jl. Sudirman No. 10, Jakarta',
        ]);

        $this->command->info('SiswaSeeder: ' . Siswa::count() . ' siswa berhasil dibuat.');
    }
}
