{{-- resources/views/nilai/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Nilai')
@section('page-title', 'Tambah Data Nilai')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-plus-circle mr-2"></i>Form Tambah Nilai Siswa
                </h6>
            </div>
            <div class="card-body">

                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('nilai.store') }}" method="POST">
                    @csrf

                    {{-- Pilih Siswa --}}
                    <div class="form-group">
                        <label>Siswa <span class="text-danger">*</span></label>
                        <select name="siswa_id" class="form-control {{ $errors->has('siswa_id') ? 'is-invalid' : '' }}">
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($siswas as $siswa)
                            <option value="{{ $siswa->id }}" {{ old('siswa_id', $selectedSiswa->id ?? '') == $siswa->id
                                ? 'selected' : '' }}>
                                {{ $siswa->nis }} - {{ $siswa->nama }}
                                ({{ $siswa->kelas->nama_kelas ?? '-' }})
                            </option>
                            @endforeach
                        </select>
                        @error('siswa_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Pilih Mata Pelajaran (auto-fill via JS) --}}
                    <div class="form-group">
                        <label>Mata Pelajaran <span class="text-danger">*</span></label>
                        <select name="kode_mapel" id="selectMapel"
                            class="form-control {{ $errors->has('kode_mapel') ? 'is-invalid' : '' }}">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($mataPelajarans as $mapel)
                            <option value="{{ $mapel['kode'] }}" data-nama="{{ $mapel['nama'] }}"
                                {{ old('kode_mapel') == $mapel['kode'] ? 'selected' : '' }}>
                                [{{ $mapel['kode'] }}] {{ $mapel['nama'] }}
                            </option>
                            @endforeach
                        </select>
                        @error('kode_mapel')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Hidden field diisi otomatis oleh JavaScript --}}
                    <input type="hidden" name="nama_mapel" id="hiddenNamaMapel" value="{{ old('nama_mapel') }}">

                    <div class="form-row">
                        {{-- Nilai Angka --}}
                        <div class="form-group col-md-6">
                            <label>Nilai Angka <span class="text-danger">*</span></label>
                            <input type="number" name="nilai_angka" id="inputNilaiAngka"
                                value="{{ old('nilai_angka') }}"
                                class="form-control {{ $errors->has('nilai_angka') ? 'is-invalid' : '' }}" min="0"
                                max="100" step="0.01" placeholder="0 - 100">
                            @error('nilai_angka')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        {{-- Preview Grade (read-only, diisi JS) --}}
                        <div class="form-group col-md-6">
                            <label>Grade <small class="text-muted">(otomatis)</small></label>
                            <input type="text" id="previewGrade" class="form-control text-center font-weight-bold"
                                placeholder="Isi nilai angka..." readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        {{-- Semester --}}
                        <div class="form-group col-md-6">
                            <label>Semester <span class="text-danger">*</span></label>
                            <select name="semester"
                                class="form-control {{ $errors->has('semester') ? 'is-invalid' : '' }}">
                                <option value="">-- Pilih Semester --</option>
                                <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected':'' }}>Ganjil</option>
                                <option value="Genap" {{ old('semester') == 'Genap'  ? 'selected':'' }}>Genap</option>
                            </select>
                            @error('semester')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        {{-- Tahun Ajaran --}}
                        <div class="form-group col-md-6">
                            <label>Tahun Ajaran <span class="text-danger">*</span></label>
                            <input type="text" name="tahun_ajaran"
                                value="{{ old('tahun_ajaran', date('Y').'/'.(date('Y')+1)) }}"
                                class="form-control {{ $errors->has('tahun_ajaran') ? 'is-invalid' : '' }}"
                                placeholder="Contoh: 2024/2025">
                            @error('tahun_ajaran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('nilai.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Simpan Nilai
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
    // Auto-fill nama_mapel saat mata pelajaran dipilih
    document.getElementById('selectMapel').addEventListener('change', function() {
        const opt = this.options[this.selectedIndex];
        const nama = opt.getAttribute('data-nama') || '';
        document.getElementById('hiddenNamaMapel').value = nama;
    });

    // Konversi nilai angka ke huruf (sama dengan Model Nilai::konversiHuruf)
    function nilaiKeHuruf(angka) {
        if (isNaN(angka)) return '';
        if (angka >= 90) return 'A';
        if (angka >= 80) return 'B';
        if (angka >= 70) return 'C';
        if (angka >= 60) return 'D';
        return 'E';
    }

    document.getElementById('inputNilaiAngka').addEventListener('input', function() {
        document.getElementById('previewGrade').value = nilaiKeHuruf(parseFloat(this.value));
    });
</script>
@endpush