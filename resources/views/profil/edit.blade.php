{{-- resources/views/profil/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        {{-- ===== KARTU INFO PROFIL ===== --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user-circle mr-2"></i>Informasi Akun
                </h6>
            </div>
            <div class="card-body">

                {{-- Avatar inisial --}}
                <div class="text-center mb-4">
                    <div class="rounded-circle bg-gradient-primary d-inline-flex
                            align-items-center justify-content-center mb-3" style="width:80px;height:80px;">
                        <span class="text-white" style="font-size:2rem;font-weight:500;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                    </div>
                    <h5 class="font-weight-bold mb-0">{{ $user->name }}</h5>
                    <small class="text-muted">{{ $user->email }}</small>
                </div>

                <table class="table table-sm table-borderless">
                    <tr>
                        <th width="30%"><i class="fas fa-user mr-1 text-muted"></i> Nama</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-envelope mr-1 text-muted"></i> Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-calendar mr-1 text-muted"></i> Bergabung</th>
                        <td>{{ $user->created_at->format('d F Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- ===== FORM EDIT NAMA & EMAIL ===== --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-edit mr-2"></i>Edit Profil
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('profil.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ===== FORM GANTI PASSWORD ===== --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">
                    <i class="fas fa-lock mr-2"></i>Ganti Password
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('profil.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Password Saat Ini <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" name="current_password" id="current_password"
                                class="form-control {{ $errors->has('current_password') ? 'is-invalid' : '' }}"
                                placeholder="Masukkan password saat ini">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="togglePassword('current_password')">
                                    <i class="fas fa-eye" id="icon-current_password"></i>
                                </button>
                            </div>
                            @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Password Baru <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" name="password" id="password"
                                class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                placeholder="Minimal 8 karakter">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="togglePassword('password')">
                                    <i class="fas fa-eye" id="icon-password"></i>
                                </button>
                            </div>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                                placeholder="Ulangi password baru">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="togglePassword('password_confirmation')">
                                    <i class="fas fa-eye" id="icon-password_confirmation"></i>
                                </button>
                            </div>
                            @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Indikator kekuatan password --}}
                    <div class="form-group">
                        <small class="text-muted">Kekuatan password:</small>
                        <div class="progress mt-1" style="height:6px;">
                            <div id="strength-bar" class="progress-bar" style="width:0%;transition:width .3s"></div>
                        </div>
                        <small id="strength-label" class="text-muted"></small>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key mr-1"></i> Perbarui Password
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
    // Toggle show/hide password
    function togglePassword(id) {
        const input = document.getElementById(id);
        const icon = document.getElementById('icon-' + id);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    // Indikator kekuatan password
    document.getElementById('password').addEventListener('input', function() {
        const val = this.value;
        let score = 0;
        if (val.length >= 8) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        const bar = document.getElementById('strength-bar');
        const label = document.getElementById('strength-label');
        const config = {
            0: {
                width: '0%',
                color: '',
                text: ''
            },
            1: {
                width: '25%',
                color: 'bg-danger',
                text: 'Lemah'
            },
            2: {
                width: '50%',
                color: 'bg-warning',
                text: 'Cukup'
            },
            3: {
                width: '75%',
                color: 'bg-info',
                text: 'Kuat'
            },
            4: {
                width: '100%',
                color: 'bg-success',
                text: 'Sangat Kuat'
            },
        };
        const c = config[score];
        bar.style.width = c.width;
        bar.className = 'progress-bar ' + c.color;
        label.textContent = c.text;
    });
</script>
@endpush