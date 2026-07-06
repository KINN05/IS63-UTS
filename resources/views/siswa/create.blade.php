{{-- resources/views/siswa/create.blade.php --}}
@extends('layouts.app')
@php use Illuminate\Support\Facades\Storage; @endphp

@section('title', 'Tambah Siswa')
@section('page-title', 'Tambah Data Siswa')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user-plus mr-2"></i>Form Tambah Siswa
                </h6>
            </div>
            <div class="card-body">
                {{-- enctype multipart WAJIB ada jika form memiliki upload file --}}
                <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        {{-- Kolom Kiri --}}
                        <div class="col-md-8">

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>NIS <span class="text-danger">*</span></label>
                                    <input type="text" name="nis" value="{{ old('nis') }}"
                                        class="form-control {{ $errors->has('nis') ? 'is-invalid' : '' }}"
                                        placeholder="Contoh: 2024001001">
                                    @error('nis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Kelas <span class="text-danger">*</span></label>
                                    <select name="kelas_id"
                                        class="form-control {{ $errors->has('kelas_id') ? 'is-invalid' : '' }}">
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach($kelas as $k)
                                        <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->kode_kelas }} - {{ $k->nama_kelas }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('kelas_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama" value="{{ old('nama') }}"
                                    class="form-control {{ $errors->has('nama') ? 'is-invalid' : '' }}"
                                    placeholder="Nama sesuai akta kelahiran">
                                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                    placeholder="email@contoh.com">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Tahun Masuk <span class="text-danger">*</span></label>
                                    <input type="number" name="tahun_masuk" value="{{ old('tahun_masuk', date('Y')) }}"
                                        class="form-control {{ $errors->has('tahun_masuk') ? 'is-invalid' : '' }}"
                                        min="2000" max="{{ date('Y') }}">
                                    @error('tahun_masuk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status"
                                        class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}">
                                        @foreach(['aktif','pindah','lulus','dropout'] as $s)
                                        <option value="{{ $s }}" {{ old('status','aktif') == $s ? 'selected' : '' }}>
                                            {{ ucfirst($s) }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>No. HP</label>
                                    <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                                        class="form-control {{ $errors->has('no_hp') ? 'is-invalid' : '' }}"
                                        placeholder="08xxxxxxxxxx">
                                    @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea name="alamat" rows="3"
                                    class="form-control {{ $errors->has('alamat') ? 'is-invalid' : '' }}"
                                    placeholder="Alamat lengkap siswa">{{ old('alamat') }}</textarea>
                                @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Kolom Kanan: Upload Foto --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Foto Siswa</label>
                                <div class="text-center mb-3">
                                    <img id="preview-foto"
                                        src="{{ asset('vendor/startbootstrap-sb-admin-2/img/undraw_profile.svg') }}"
                                        class="img-thumbnail rounded" width="150" height="150" style="object-fit:cover">
                                </div>
                                <input type="file" name="foto" id="foto"
                                    class="form-control-file {{ $errors->has('foto') ? 'is-invalid' : '' }}"
                                    accept="image/jpg,image/jpeg,image/png" onchange="previewFoto(this)">
                                <small class="form-text text-muted">
                                    Format: JPG/PNG. Maks: 2MB.
                                </small>
                                @error('foto')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('siswa.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Simpan Data
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
    function previewFoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-foto').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush