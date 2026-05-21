<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilais';

    protected $fillable = [
        'siswa_id',
        'kode_mapel',
        'nama_mapel',
        'nilai_angka',
        'nilai_huruf',
        'semester',
        'tahun_ajaran',
    ];

    protected $casts = [
        'nilai_angka' => 'float',
    ];

    // ===== RELASI =====

    /**
     * Nilai MILIK satu Siswa
     * Relasi: belongsTo
     * Akses: $nilai->siswa->nama
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    // ===== HELPER: konversi nilai angka ke huruf =====
    public static function konversiHuruf(float $angka): string
    {
        return match (true) {
            $angka >= 90 => 'A',
            $angka >= 80 => 'B',
            $angka >= 70 => 'C',
            $angka >= 60 => 'D',
            default      => 'E',
        };
    }
}
