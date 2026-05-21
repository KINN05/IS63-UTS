<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';

    protected $fillable = [
        'kelas_id',
        'nis',
        'nama',
        'email',
        'tahun_masuk',
        'status',
        'no_hp',
        'alamat',
        'foto',
    ];

    // ===== RELASI =====

    /**
     * Siswa MILIK satu Kelas
     * Relasi: belongsTo
     * Akses: $siswa->kelas->nama_kelas
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Satu Siswa memiliki BANYAK Nilai
     * Relasi: hasMany
     * Akses: $siswa->nilais
     */
    public function nilais()
    {
        return $this->hasMany(Nilai::class, 'siswa_id');
    }

    // ===== HELPER METHOD =====

    /**
     * Hitung rata-rata nilai angka siswa
     */
    public function getRataRataNilaiAttribute(): float
    {
        if ($this->nilais->isEmpty()) return 0;
        return round($this->nilais->avg('nilai_angka'), 2);
    }
}
