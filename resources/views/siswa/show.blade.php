{{-- resources/views/siswa/show.blade.php --}}
@extends('layouts.app')
@php use Illuminate\Support\Facades\Storage; @endphp

@section('title', $siswa->nama)
@section('page-title', 'Detail Siswa')

@section('page-action')
<div class="d-flex gap-2">
    <a href="{{ route('siswa.edit', $siswa) }}" class="btn btn-warning btn-sm">
        <i class="fas fa-edit mr-1"></i> Edit
    </a>
    <a href="{{ route('nilai.create', ['siswa_id' => $siswa->id]) }}" class="btn btn-success btn-sm">
        <i class="fas fa-plus mr-1"></i> Tambah Nilai
    </a>
</div>
@endsection

@section('content')
<div class="row">

    {{-- ===== KOLOM KIRI: PROFIL ===== --}}
    <div class="col-xl-4 col-lg-5">

        {{-- Kartu Foto & Nama --}}
        <div class="card shadow mb-4">
            <div class="card-body text-center py-4">
                @if($siswa->foto)
                <img src="{{ Storage::url($siswa->foto) }}" class="rounded-circle mb-3"
                    style="width:120px;height:120px;object-fit:cover;">
                @else
                <div class="rounded-circle bg-gradient-primary d-inline-flex
                                align-items-center justify-content-center mb-3" style="width:120px;height:120px;">
                    <span class="text-white" style="font-size:3rem;font-weight:700;">
                        {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                    </span>
                </div>
                @endif
                <h5 class="font-weight-bold mb-1">{{ $siswa->nama }}</h5>
                <p class="text-muted mb-2"><code>{{ $siswa->nis }}</code></p>
                @php
                $badgeColor = match($siswa->status) {
                'aktif' => 'success',
                'pindah' => 'warning',
                'lulus' => 'info',
                'dropout' => 'danger',
                default => 'secondary'
                };
                @endphp
                <span class="badge badge-{{ $badgeColor }} badge-pill px-3 py-2">
                    {{ ucfirst($siswa->status) }}
                </span>
            </div>
        </div>

        {{-- Kartu Informasi Detail --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Siswa</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <th width="40%"><i class="fas fa-chalkboard mr-1 text-muted"></i> Kelas</th>
                        <td>
                            <a href="{{ route('kelas.show', $siswa->kelas) }}">
                                {{ $siswa->kelas->nama_kelas ?? '-' }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-layer-group mr-1 text-muted"></i> Tingkat</th>
                        <td>
                            <span class="badge badge-info">
                                {{ $siswa->kelas->tingkat ?? '-' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-book mr-1 text-muted"></i> Jurusan</th>
                        <td>
                            <span class="badge badge-secondary">
                                {{ $siswa->kelas->jurusan ?? '-' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-calendar mr-1 text-muted"></i> Tahun Masuk</th>
                        <td>{{ $siswa->tahun_masuk }}</td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-envelope mr-1 text-muted"></i> Email</th>
                        <td><small>{{ $siswa->email }}</small></td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-phone mr-1 text-muted"></i> No. HP</th>
                        <td>{{ $siswa->no_hp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-map-marker-alt mr-1 text-muted"></i> Alamat</th>
                        <td><small>{{ $siswa->alamat ?? '-' }}</small></td>
                    </tr>
                </table>
            </div>
        </div>
        <a href="{{ route('siswa.index') }}" class="btn btn-secondary btn-block mb-4">
            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
        </a>
    </div>

    {{-- ===== KOLOM KANAN: NILAI ===== --}}
    <div class="col-xl-8 col-lg-7">

        {{-- Kartu Statistik Nilai --}}
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Mata Pelajaran
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $siswa->nilais->count() }} Mapel
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Rata-rata Nilai
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($siswa->nilais->avg('nilai_angka') ?? 0, 2) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Rekap Nilai --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-bar mr-2"></i>Rekap Nilai
                </h6>
                <a href="{{ route('nilai.create', ['siswa_id' => $siswa->id]) }}"
                    class="btn btn-success btn-sm">
                    <i class="fas fa-plus mr-1"></i> Tambah Nilai
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Kode Mapel</th>
                                <th>Nama Mata Pelajaran</th>
                                <th class="text-center" width="8%">Nilai</th>
                                <th class="text-center" width="7%">Grade</th>
                                <th width="8%">Semester</th>
                                <th width="10%">Tahun Ajaran</th>
                                <th class="text-center" width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswa->nilais as $nilai)
                            <tr>
                                <td><code>{{ $nilai->kode_mapel }}</code></td>
                                <td>{{ $nilai->nama_mapel }}</td>
                                <td class="text-center font-weight-bold">
                                    {{ number_format($nilai->nilai_angka, 1) }}
                                </td>
                                <td class="text-center">
                                    @php
                                    $gc = match($nilai->nilai_huruf) {
                                    'A' => 'success',
                                    'B' => 'primary',
                                    'C' => 'warning',
                                    'D' => 'secondary',
                                    default => 'danger' // E
                                    };
                                    @endphp
                                    <span class="badge badge-{{ $gc }}">
                                        {{ $nilai->nilai_huruf }}
                                    </span>
                                </td>
                                <td>{{ $nilai->semester }}</td>
                                <td class="text-center">{{ $nilai->tahun_ajaran }}</td>
                                <td class="text-center">
                                    <a href="{{ route('nilai.edit', $nilai) }}"
                                        class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm"
                                        title="Hapus"
                                        onclick="hapusNilai({{ $nilai->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <form id="form-hapus-nilai-{{ $nilai->id }}"
                                        action="{{ route('nilai.destroy', $nilai) }}"
                                        method="POST" style="display:none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">
                                    Belum ada data nilai. Klik "Tambah Nilai" untuk menambahkan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    function hapusNilai(id) {
        if (confirm('Hapus nilai ini? Aksi tidak bisa dibatalkan.')) {
            document.getElementById('form-hapus-nilai-' + id).submit();
        }
    }
</script>
@endpush
