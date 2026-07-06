<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Ambil ID siswa dari URL parameter {siswa}
        $siswaId = $this->route('siswa')->id;

        return [
            'kelas_id'    => 'required|exists:kelas,id',
            // unique kecuali ID siswa yang sedang diedit
            'nis'         => 'required|string|max:20|unique:siswas,nis,' . $siswaId,
            'nama'        => 'required|string|max:100',
            'email'       => 'required|email|max:100|unique:siswas,email,' . $siswaId,
            'tahun_masuk' => 'required|digits:4|integer|min:2000|max:' . date('Y'),
            'status'      => 'required|in:aktif,pindah,lulus,dropout',
            'no_hp'       => 'nullable|string|max:15',
            'alamat'      => 'nullable|string',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'nis.unique'   => 'NIS sudah digunakan oleh siswa lain.',
            'email.unique' => 'Email sudah digunakan oleh siswa lain.',
        ];
    }
}
