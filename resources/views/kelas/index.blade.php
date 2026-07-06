{{-- resources/views/kelas/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Kelas')
@section('page-title', 'Data Kelas')

@section('page-action')
<a href="{{ route('kelas.create') }}" class="btn btn-primary btn-sm shadow-sm">
    <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Tambah Kelas
</a>
@endsection

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-chalkboard mr-2"></i>Daftar Kelas
        </h6>
        <span class="badge badge-primary badge-pill">
            {{ $kelas->total() }} Total
        </span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%">
                <thead class="thead-light">
                    <tr>
                        <th width="5%">#</th>
                        <th>Kode Kelas</th>
                        <th>Nama Kelas</th>
                        <th width="8%">Tingkat</th>
                        <th width="10%">Jurusan</th>
                        <th width="15%">Jumlah Siswa</th>
                        <th width="10%">Status</th>
                        <th width="18%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelas as $item)
                    <tr>
                        <td>{{ $kelas->firstItem() + $loop->index }}</td>
                        <td><strong>{{ $item->kode_kelas }}</strong></td>
                        <td>{{ $item->nama_kelas }}</td>
                        <td>
                            <span class="badge badge-{{ $item->tingkat === 'XII' ? 'warning' : 'info' }}">
                                {{ $item->tingkat }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-secondary">
                                {{ $item->jurusan }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('kelas.show', $item) }}" class="text-primary font-weight-bold">
                                {{ $item->siswas_count }} siswa
                            </a>
                        </td>
                        <td>
                            <span class="badge badge-{{ $item->status === 'aktif' ? 'success' : 'secondary' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('kelas.show', $item) }}" class="btn btn-info btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('kelas.edit', $item) }}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-danger btn-sm" title="Hapus"
                                onclick="konfirmasiHapus({{ $item->id }}, '{{ $item->nama_kelas }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                            {{-- Form hapus tersembunyi --}}
                            <form id="form-hapus-{{ $item->id }}" action="{{ route('kelas.destroy', $item) }}"
                                method="POST" style="display:none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            Belum ada data kelas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-between align-items-center mt-3">
            <small class="text-muted">
                Menampilkan {{ $kelas->firstItem() }}–{{ $kelas->lastItem() }}
                dari {{ $kelas->total() }} data
            </small>
            {{ $kelas->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function konfirmasiHapus(id, nama) {
        if (confirm('Hapus kelas "' + nama + '"?\nAksi ini tidak bisa dibatalkan.')) {
            document.getElementById('form-hapus-' + id).submit();
        }
    }
</script>
@endpush