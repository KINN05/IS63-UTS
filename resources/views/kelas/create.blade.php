{{-- resources/views/kelas/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Kelas')
@section('page-title', 'Tambah Kelas')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-plus-circle mr-2"></i>Form Tambah Kelas
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('kelas.store') }}" method="POST">
                    @csrf

                    <div class="form-row">
                        {{-- Kode Kelas --}}
                        <div class="form-group col-md-4">
                            <label>Kode Kelas <span class="text-danger">*</span></label>
                            <input type="text" name="kode_kelas" value="{{ old('kode_kelas') }}"
                                class="form-control {{ $errors->has('kode_kelas') ? 'is-invalid' : '' }}"
                                placeholder="Contoh: X-A, XI-B, XII-C" maxlength="10">
                            @error('kode_kelas')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tingkat --}}
                        <div class="form-group col-md-4">
                            <label>Tingkat <span class="text-danger">*</span></label>
                            <select name="tingkat"
                                class="form-control {{ $errors->has('tingkat') ? 'is-invalid' : '' }}">
                                <option value="">-- Pilih Tingkat --</option>
                                @foreach(['X','XI','XII'] as $t)
                                <option value="{{ $t }}" {{ old('tingkat') == $t ? 'selected' : '' }}>
                                    {{ $t }}
                                </option>
                                @endforeach
                            </select>
                            @error('tingkat')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jurusan --}}
                        <div class="form-group col-md-4">
                            <label>Jurusan <span class="text-danger">*</span></label>
                            <select name="jurusan"
                                class="form-control {{ $errors->has('jurusan') ? 'is-invalid' : '' }}">
                                <option value="">-- Pilih Jurusan --</option>
                                @foreach(['IPA','IPS','Bahasa','SMK'] as $j)
                                <option value="{{ $j }}" {{ old('jurusan') == $j ? 'selected' : '' }}>
                                    {{ $j }}
                                </option>
                                @endforeach
                            </select>
                            @error('jurusan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        {{-- Nama Kelas --}}
                        <div class="form-group col-md-8">
                            <label>Nama Kelas <span class="text-danger">*</span></label>
                            <input type="text" name="nama_kelas" value="{{ old('nama_kelas') }}"
                                class="form-control {{ $errors->has('nama_kelas') ? 'is-invalid' : '' }}"
                                placeholder="Contoh: Kelas X IPA A">
                            @error('nama_kelas')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="form-group col-md-4">
                            <label>Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}">
                                <option value="aktif" {{ old('status','aktif') == 'aktif'    ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Non-Aktif
                                </option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('kelas.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection