{{-- resources/views/siswa/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Data Siswa')
@section('page-title', 'Data Siswa')

@section('page-action')
<a href="{{ route('siswa.create') }}" class="btn btn-primary btn-sm shadow-sm">
    <i class="fas fa-plus fa-sm mr-1"></i> Tambah Siswa
</a>
@endsection

@section('content')

{{-- Form Filter --}}
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-secondary">
            <i class="fas fa-filter mr-2"></i>Filter Data
        </h6>
    </div>
    <div class="card-body py-3">
        <form method="GET" action="{{ route('siswa.index') }}">
            <div class="form-row align-items-end">
                <div class="form-group col-md-4 mb-2">
                    <label class="small font-weight-bold">Cari Nama / NIS</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="form-control form-control-sm" placeholder="Ketik nama atau NIS...">
                </div>
                <div class="form-group col-md-2 mb-2">
                    <label class="small font-weight-bold">Status</label>
                    <select name="status" class="form-control form-control-sm">
                        <option value="">Semua Status</option>
                        @foreach(['aktif','pindah','lulus','dropout'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>
                            {{ ucfirst($s) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3 mb-2">
                    <label class="small font-weight-bold">Kelas</label>
                    <select name="kelas_id" class="form-control form-control-sm">
                        <option value="">Semua Kelas</option>
                        @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2 mb-2">
                    <label class="small font-weight-bold">Tahun Masuk</label>
                    <input type="number" name="tahun_masuk" value="{{ request('tahun_masuk') }}"
                        class="form-control form-control-sm" placeholder="2022">
                </div>
                <div class="form-group col-md-1 mb-2">
                    <button type="submit" class="btn btn-primary btn-sm btn-block">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            @if(request()->hasAny(['search','status','kelas_id','tahun_masuk']))
            <a href="{{ route('siswa.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-times mr-1"></i>Reset Filter
            </a>
            @endif
        </form>
    </div>
</div>

{{-- Tabel Data --}}
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-user-graduate mr-2"></i>Daftar Siswa
        </h6>
        <span class="text-muted small">{{ $siswas->total() }} data ditemukan</span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th width="5%">#</th>
                        <th width="12%">NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th width="10%">Tahun Masuk</th>
                        <th width="10%">Status</th>
                        <th width="18%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswas as $siswa)
                    <tr>
                        <td>{{ $siswas->firstItem() + $loop->index }}</td>
                        <td><code>{{ $siswa->nis }}</code></td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($siswa->foto)
                                <img src="{{ Storage::url($siswa->foto) }}" class="rounded-circle mr-2" width="32"
                                    height="32" style="object-fit:cover">
                                @else
                                <div class="rounded-circle bg-primary d-flex align-items-center
                                                justify-content-center mr-2 text-white"
                                    style="width:32px;height:32px;font-size:14px;flex-shrink:0">
                                    {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                                </div>
                                @endif
                                <div>
                                    <div class="font-weight-bold">{{ $siswa->nama }}</div>
                                    <small class="text-muted">{{ $siswa->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                        <td class="text-center">{{ $siswa->tahun_masuk }}</td>
                        <td>
                            @php
                            $badgeColor = match($siswa->status) {
                            'aktif' => 'success',
                            'pindah' => 'warning',
                            'lulus' => 'info',
                            'dropout' => 'danger',
                            default => 'secondary'
                            };
                            @endphp
                            <span class="badge badge-{{ $badgeColor }}">
                                {{ ucfirst($siswa->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('siswa.show', $siswa) }}" class="btn btn-info btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('siswa.edit', $siswa) }}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-danger btn-sm"
                                onclick="konfirmasiHapus({{ $siswa->id }}, '{{ $siswa->nama }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                            <form id="form-hapus-{{ $siswa->id }}" action="{{ route('siswa.destroy', $siswa) }}"
                                method="POST" style="display:none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="fas fa-search fa-2x mb-2 d-block"></i>
                            Tidak ada data siswa yang sesuai filter.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-3">
            <small class="text-muted">
                Menampilkan {{ $siswas->firstItem() }}–{{ $siswas->lastItem() }}
                dari {{ $siswas->total() }} data
            </small>
            {{ $siswas->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function konfirmasiHapus(id, nama) {
        if (confirm('Hapus siswa "' + nama + '"?\nSemua data nilai siswa ini juga akan terhapus!')) {
            document.getElementById('form-hapus-' + id).submit();
        }
    }
</script>
@endpush