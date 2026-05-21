<?php
// database/seeders/KelasSeeder.php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        // Data kelas yang pasti ada (data statis)
        $kelas = [
            ['kode_kelas' => 'X-A',   'nama_kelas' => 'Kelas X IPA A',    'tingkat' => 'X',   'jurusan' => 'IPA',    'status' => 'aktif'],
            ['kode_kelas' => 'X-B',   'nama_kelas' => 'Kelas X IPA B',    'tingkat' => 'X',   'jurusan' => 'IPA',    'status' => 'aktif'],
            ['kode_kelas' => 'X-C',   'nama_kelas' => 'Kelas X IPS A',    'tingkat' => 'X',   'jurusan' => 'IPS',    'status' => 'aktif'],
            ['kode_kelas' => 'XI-A',  'nama_kelas' => 'Kelas XI IPA A',   'tingkat' => 'XI',  'jurusan' => 'IPA',    'status' => 'aktif'],
            ['kode_kelas' => 'XI-B',  'nama_kelas' => 'Kelas XI IPS A',   'tingkat' => 'XI',  'jurusan' => 'IPS',    'status' => 'aktif'],
            ['kode_kelas' => 'XII-A', 'nama_kelas' => 'Kelas XII IPA A',  'tingkat' => 'XII', 'jurusan' => 'IPA',    'status' => 'aktif'],
            ['kode_kelas' => 'XII-B', 'nama_kelas' => 'Kelas XII IPS A',  'tingkat' => 'XII', 'jurusan' => 'IPS',    'status' => 'aktif'],
            ['kode_kelas' => 'XII-C', 'nama_kelas' => 'Kelas XII Bahasa', 'tingkat' => 'XII', 'jurusan' => 'Bahasa', 'status' => 'aktif'],
        ];

        foreach ($kelas as $item) {
            Kelas::create($item);
        }

        $this->command->info('KelasSeeder: ' . count($kelas) . ' kelas berhasil dibuat.');
    }
}
