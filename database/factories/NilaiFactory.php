<?php

namespace Database\Factories;

use App\Models\Siswa;
use App\Models\Nilai;
use Illuminate\Database\Eloquent\Factories\Factory;

class NilaiFactory extends Factory
{
    private static array $mataPelajaran = [
        ['kode' => 'MTK01', 'nama' => 'Matematika'],
        ['kode' => 'BIN01', 'nama' => 'Bahasa Indonesia'],
        ['kode' => 'BIG01', 'nama' => 'Bahasa Inggris'],
        ['kode' => 'FIS01', 'nama' => 'Fisika'],
        ['kode' => 'KIM01', 'nama' => 'Kimia'],
        ['kode' => 'BIO01', 'nama' => 'Biologi'],
        ['kode' => 'SEJ01', 'nama' => 'Sejarah'],
        ['kode' => 'PKN01', 'nama' => 'Pendidikan Kewarganegaraan'],
        ['kode' => 'SEN01', 'nama' => 'Seni Budaya'],
        ['kode' => 'PJK01', 'nama' => 'Pendidikan Jasmani'],
    ];

    public function definition(): array
    {
        $mapel      = fake()->randomElement(self::$mataPelajaran);
        $nilaiAngka = fake()->randomFloat(2, 45, 100);
        $tahunAwal  = fake()->numberBetween(2020, 2024);
        $tahunAjaran = $tahunAwal . '/' . ($tahunAwal + 1);

        return [
            'siswa_id'    => Siswa::inRandomOrder()->value('id'),
            'kode_mapel'  => $mapel['kode'],
            'nama_mapel'  => $mapel['nama'],
            'nilai_angka' => $nilaiAngka,
            'nilai_huruf' => Nilai::konversiHuruf($nilaiAngka),
            'semester'    => fake()->randomElement(['Ganjil', 'Genap']),
            'tahun_ajaran' => $tahunAjaran,
        ];
    }
}
