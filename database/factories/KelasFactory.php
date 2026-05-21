<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KelasFactory extends Factory
{
    public function definition(): array
    {
        $kelas = [
            ['kode' => 'X-A',    'nama' => 'Kelas X IPA A',    'tingkat' => 'X',   'jurusan' => 'IPA'],
            ['kode' => 'X-B',    'nama' => 'Kelas X IPA B',    'tingkat' => 'X',   'jurusan' => 'IPA'],
            ['kode' => 'X-C',    'nama' => 'Kelas X IPS A',    'tingkat' => 'X',   'jurusan' => 'IPS'],
            ['kode' => 'XI-A',   'nama' => 'Kelas XI IPA A',   'tingkat' => 'XI',  'jurusan' => 'IPA'],
            ['kode' => 'XI-B',   'nama' => 'Kelas XI IPS A',   'tingkat' => 'XI',  'jurusan' => 'IPS'],
            ['kode' => 'XII-A',  'nama' => 'Kelas XII IPA A',  'tingkat' => 'XII', 'jurusan' => 'IPA'],
            ['kode' => 'XII-B',  'nama' => 'Kelas XII IPS A',  'tingkat' => 'XII', 'jurusan' => 'IPS'],
            ['kode' => 'XII-C',  'nama' => 'Kelas XII Bahasa', 'tingkat' => 'XII', 'jurusan' => 'Bahasa'],
        ];

        $item = fake()->unique()->randomElement($kelas);

        return [
            'kode_kelas' => $item['kode'],
            'nama_kelas' => $item['nama'],
            'tingkat'    => $item['tingkat'],
            'jurusan'    => $item['jurusan'],
            'status'     => 'aktif',
        ];
    }
}
