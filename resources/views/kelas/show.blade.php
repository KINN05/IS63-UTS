{{-- resources/views/kelas/show.blade.php --}}
@extends('layouts.app')

@section('title', $kelas->nama_kelas)
@section('page-title', 'Detail Kelas')

@section('page-action')
<a href="{{ route('kelas.edit', $kelas) }}" class="btn btn-warning btn-sm">
    <i class="fas fa-edit mr-1"></i> Edit Kelas
</a>
@endsection

@section('content')
<div class="row">

    {{-- Info Kelas --}}
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-primary">
                <h6 class="m-0 font-weight-bold text-white">
                    <i class="fas fa-chalkboard mr-2"></i>Informasi Kelas
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <th width="40%">Kode</th>
                        <td>{{ $kelas->kode_kelas }}</td>
                    </tr>
                    <tr>
                        <th>Nama Kelas</th>
                        <td>{{ $kelas->nama_kelas }}</td>
                    </tr>
                    <tr>
                        <th>Tingkat</th>
                        <td><span class="badge badge-info">{{ $kelas->tingkat }}</span></td>
                    </tr>
                    <tr>
                        <th>Jurusan</th>
                        <td><span class="badge badge-secondary">{{ $kelas->jurusan }}</span></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge badge-{{ $kelas->status === 'aktif' ? 'success' : 'secondary' }}">
                                {{ ucfirst($kelas->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Total Siswa</th>
                        <td><strong>{{ $siswas->total() }}</strong> orang</td>
                    </tr>
                </table>
                <hr>
                <a href="{{ route('kelas.index') }}" class="btn btn-secondary btn-block btn-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    {{-- Tabel Siswa di Kelas Ini --}}
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    Siswa — {{ $kelas->nama_kelas }}
                </h6>
                <a href="{{ route('siswa.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus mr-1"></i> Tambah Siswa
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th class="text-center">Tahun Masuk</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswas as $siswa)
                            <tr>
                                <td><code>{{ $siswa->nis }}</code></td>
                                <td>
                                    <a href="{{ route('siswa.show', $siswa) }}">
                                        {{ $siswa->nama }}
                                    </a>
                                </td>
                                <td class="text-center">{{ $siswa->tahun_masuk }}</td>
                                <td class="text-center">
                                    @php
                                    $bc = match($siswa->status) {
                                    'aktif' => 'success',
                                    'pindah' => 'warning',
                                    'lulus' => 'info',
                                    'dropout' => 'danger',
                                    default => 'secondary'
                                    };
                                    @endphp
                                    <span class="badge badge-{{ $bc }}">{{ ucfirst($siswa->status) }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('siswa.show', $siswa) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">
                                    Belum ada siswa di kelas ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-muted">
                        Menampilkan {{ $siswas->firstItem() ?? 0 }}–{{ $siswas->lastItem() ?? 0 }}
                        dari {{ $siswas->total() }} siswa
                    </small>
                    {{ $siswas->links() }}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection