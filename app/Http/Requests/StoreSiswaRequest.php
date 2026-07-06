<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiswaRequest extends FormRequest
{
    /**
     * Siapa yang boleh menggunakan request ini?
     * true = semua user yang sudah login boleh
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi untuk menambah siswa baru
     */
    public function rules(): array
    {
        return [
            'kelas_id'    => 'required|exists:kelas,id',
            'nis'         => 'required|string|max:20|unique:siswas,nis',
            'nama'        => 'required|string|max:100',
            'email'       => 'required|email|max:100|unique:siswas,email',
            'tahun_masuk' => 'required|digits:4|integer|min:2000|max:' . date('Y'),
            'status'      => 'required|in:aktif,pindah,lulus,dropout',
            'no_hp'       => 'nullable|string|max:15',
            'alamat'      => 'nullable|string',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    /**
     * Pesan error kustom
     */
    public function messages(): array
    {
        return [
            'kelas_id.required'    => 'Kelas wajib dipilih.',
            'kelas_id.exists'      => 'Kelas tidak valid.',
            'nis.required'         => 'NIS wajib diisi.',
            'nis.unique'           => 'NIS sudah terdaftar di sistem.',
            'email.unique'         => 'Email sudah digunakan oleh siswa lain.',
            'tahun_masuk.digits'   => 'Tahun masuk harus berupa tahun 4 digit.',
            'foto.image'           => 'File foto harus berupa gambar (jpg/png).',
            'foto.max'             => 'Ukuran foto maksimal 2MB.',
        ];
    }

    /**
     * Atribut kustom untuk nama field (ditampilkan di pesan error)
     */
    public function attributes(): array
    {
        return [
            'kelas_id'    => 'Kelas',
            'nis'         => 'NIS',
            'nama'        => 'Nama Lengkap',
            'email'       => 'Alamat Email',
            'tahun_masuk' => 'Tahun Masuk',
            'no_hp'       => 'Nomor HP',
        ];
    }
}
