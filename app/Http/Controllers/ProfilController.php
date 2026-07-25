<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfilRequest;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    /**
     * edit() — Tampilkan form profil
     * GET /profil
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profil.edit', compact('user'));
    }

    /**
     * update() — Perbarui nama dan email
     * PUT /profil
     */
    public function update(UpdateProfilRequest $request)
    {
        $user = Auth::user();
        $user->update($request->validated());

        return redirect()
            ->route('profil.edit')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * updatePassword() — Perbarui password
     * PUT /profil/password
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('profil.edit')
            ->with('success', 'Password berhasil diperbarui!');
    }
}
