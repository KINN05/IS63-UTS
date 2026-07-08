{{-- resources/views/nilai/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Nilai')
@section('page-title', 'Edit Data Nilai')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Nilai: {{ $nilai->siswa->nama }} &mdash; {{ $nilai->nama_mapel }}
                </h6>
            </div>
            <div class="card-body">

                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
                @endif

                {{-- Info banner siswa yang nilainya sedang diedit --}}
                <div class="alert alert-info py-2">
                    <i class="fas fa-info-circle mr-1"></i>
                    Mengedit nilai <strong>{{ $nilai->nama_mapel }}</strong>
                    milik <strong>{{ $nilai->siswa->nama }}</strong>
                    (<code>{{ $nilai->siswa->nis }}</code>)
                </div>

                <form action="{{ route('nilai.update', $nilai) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Pilih Siswa --}}
                    <div class="form-group">
                        <label>Siswa <span class="text-danger">*</span></label>
                        <select name="siswa_id" class="form-control">
                            @foreach($siswas as $siswa)
                            <option value="{{ $siswa->id }}" {{ old('siswa_id', $nilai->siswa_id) == $siswa->id
                                ? 'selected' : '' }}>
                                {{ $siswa->nis }} - {{ $siswa->nama }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Pilih Mata Pelajaran --}}
                    <div class="form-group">
                        <label>Mata Pelajaran <span class="text-danger">*</span></label>
                        <select name="kode_mapel" id="selectMapelEdit" class="form-control">
                            @foreach($mataPelajarans as $mapel)
                            <option value="{{ $mapel['kode'] }}" data-nama="{{ $mapel['nama'] }}" {{ old('kode_mapel', $nilai->kode_mapel) == $mapel['kode']
                                    ? 'selected' : '' }}>
                                [{{ $mapel['kode'] }}] {{ $mapel['nama'] }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <input type="hidden" name="nama_mapel" id="hiddenNamaMapelEdit"
                        value="{{ old('nama_mapel', $nilai->nama_mapel) }}">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Nilai Angka <span class="text-danger">*</span></label>
                            <input type="number" name="nilai_angka" id="inputNilaiEdit"
                                value="{{ old('nilai_angka', $nilai->nilai_angka) }}" class="form-control" min="0"
                                max="100" step="0.01">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Grade <small class="text-muted">(otomatis)</small></label>
                            <input type="text" id="previewGradeEdit" value="{{ $nilai->nilai_huruf }}"
                                class="form-control text-center font-weight-bold" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Semester <span class="text-danger">*</span></label>
                            <select name="semester" class="form-control">
                                <option value="Ganjil" {{ old('semester',$nilai->semester)=='Ganjil'?'selected':'' }}>
                                    Ganjil</option>
                                <option value="Genap" {{ old('semester',$nilai->semester)=='Genap' ?'selected':'' }}>
                                    Genap</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Tahun Ajaran <span class="text-danger">*</span></label>
                            <input type="text" name="tahun_ajaran"
                                value="{{ old('tahun_ajaran', $nilai->tahun_ajaran) }}" class="form-control"
                                placeholder="Contoh: 2024/2025">
                        </div>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('siswa.show', $nilai->siswa) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Detail Siswa
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save mr-1"></i> Perbarui Nilai
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function nilaiKeHuruf(angka) {
        if (isNaN(angka)) return '';
        if (angka >= 90) return 'A';
        if (angka >= 80) return 'B';
        if (angka >= 70) return 'C';
        if (angka >= 60) return 'D';
        return 'E';
    }
    document.getElementById('selectMapelEdit').addEventListener('change', function() {
        const opt = this.options[this.selectedIndex];
        document.getElementById('hiddenNamaMapelEdit').value = opt.getAttribute('data-nama') || '';
    });
    document.getElementById('inputNilaiEdit').addEventListener('input', function() {
        document.getElementById('previewGradeEdit').value = nilaiKeHuruf(parseFloat(this.value));
    });
</script>
@endpush