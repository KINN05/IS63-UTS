<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'kode_kelas',
        'nama_kelas',
        'tingkat',
        'jurusan',
        'status',
    ];

    // ===== RELASI =====

    /**
     * Satu Kelas memiliki BANYAK Siswa
     * Relasi: hasMany
     */
    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }
}
