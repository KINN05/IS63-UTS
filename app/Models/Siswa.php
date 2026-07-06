<?php
// app/Models/Siswa.php — VERSI FINAL

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table    = 'siswas';
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
    protected $casts = [
        'tahun_masuk' => 'integer',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    // ===== RELASI =====
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
    public function nilais()
    {
        return $this->hasMany(Nilai::class, 'siswa_id');
    }

    // ===== SCOPE =====
    public function scopeAktif($q)
    {
        return $q->where('status', 'aktif');
    }
    public function scopeTahunMasuk($q, int $t)
    {
        return $q->where('tahun_masuk', $t);
    }
    public function scopeDariKelas($q, int $id)
    {
        return $q->where('kelas_id', $id);
    }
    public function scopeCari($q, string $kw)
    {
        return $q->where(fn($s) => $s->where('nama', 'like', "%{$kw}%")->orWhere('nis', 'like', "%{$kw}%"));
    }

    // ===== ACCESSOR & MUTATOR =====
    protected function nama(): Attribute
    {
        return Attribute::make(get: fn($v) => ucwords(strtolower($v)));
    }
    protected function nis(): Attribute
    {
        return Attribute::make(set: fn($v) => strtoupper(trim($v)));
    }
    protected function statusLabel(): Attribute
    {
        return Attribute::make(get: fn() => match ($this->status) {
            'aktif'   => 'success',
            'pindah'  => 'warning',
            'lulus'   => 'info',
            'dropout' => 'danger',
            default   => 'secondary',
        });
    }

    // ===== HELPER =====
    public function getRataRataNilaiAttribute(): float
    {
        return round($this->nilais->avg('nilai_angka') ?? 0, 2);
    }
}
