<?php

namespace Database\Factories;

use App\Models\Kelas;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiswaFactory extends Factory
{
    public function definition(): array
    {
        $tahunMasuk = fake()->numberBetween(2020, 2024);

        // Ambil kelas_id secara acak dari data yang sudah ada di database
        $kelasId = Kelas::inRandomOrder()->value('id');

        return [
            'kelas_id'    => $kelasId,
            'nis'         => $tahunMasuk . fake()->unique()->numerify('######'),
            'nama'        => fake()->name(),
            'email'       => fake()->unique()->safeEmail(),
            'tahun_masuk' => $tahunMasuk,
            'status'      => fake()->randomElement([
                'aktif',
                'aktif',
                'aktif',
                'pindah',
                'lulus'
            ]),
            'no_hp'       => '08' . fake()->numerify('##########'),
            'alamat'      => fake()->address(),
            'foto'        => null,
        ];
    }
}
