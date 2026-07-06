<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * index() — Tampilkan daftar kelas
     * GET /kelas
     */
    public function index()
    {
        $kelas = Kelas::withCount('siswas')
            ->orderBy('nama_kelas')
            ->paginate(10);

        return view('kelas.index', compact('kelas'));
    }

    /**
     * create() — Tampilkan form tambah kelas
     * GET /kelas/create
     */
    public function create()
    {
        return view('kelas.create');
    }

    /**
     * store() — Simpan kelas baru ke database
     * POST /kelas
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'kode_kelas' => 'required|string|max:10|unique:kelas,kode_kelas',
            'nama_kelas' => 'required|string|max:100',
            'tingkat'    => 'required|in:X,XI,XII',
            'jurusan'    => 'required|in:IPA,IPS,Bahasa,SMK',
            'status'     => 'required|in:aktif,nonaktif',
        ], [
            // Pesan error kustom (opsional)
            'kode_kelas.required' => 'Kode kelas wajib diisi.',
            'kode_kelas.unique'   => 'Kode kelas sudah digunakan.',
            'nama_kelas.required' => 'Nama kelas wajib diisi.',
            'tingkat.in'          => 'Tingkat harus X, XI, atau XII.',
            'jurusan.in'          => 'Jurusan harus IPA, IPS, Bahasa, atau SMK.',
        ]);

        Kelas::create($validated);

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan!');
    }

    /**
     * show() — Tampilkan detail kelas beserta daftar siswanya
     * GET /kelas/{kelas}
     */
    public function show(Kelas $kelas)
    {
        // Eager load siswa dengan pagination
        $siswas = $kelas->siswas()
            ->orderBy('nama')
            ->paginate(10);

        return view('kelas.show', compact('kelas', 'siswas'));
    }

    /**
     * edit() — Tampilkan form edit kelas
     * GET /kelas/{kelas}/edit
     */
    public function edit(Kelas $kelas)
    {
        return view('kelas.edit', compact('kelas'));
    }

    /**
     * update() — Perbarui data kelas
     * PUT /kelas/{kelas}
     */
    public function update(Request $request, Kelas $kelas)
    {
        $validated = $request->validate([
            // unique kecuali record kelas ini sendiri (ignore ID saat ini)
            'kode_kelas' => 'required|string|max:10|unique:kelas,kode_kelas,' . $kelas->id,
            'nama_kelas' => 'required|string|max:100',
            'tingkat'    => 'required|in:X,XI,XII',
            'jurusan'    => 'required|in:IPA,IPS,Bahasa,SMK',
            'status'     => 'required|in:aktif,nonaktif',
        ]);

        $kelas->update($validated);

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Kelas berhasil diperbarui!');
    }

    /**
     * destroy() — Hapus data kelas
     * DELETE /kelas/{kelas}
     */
    public function destroy(Kelas $kelas)
    {
        // Cegah hapus jika masih ada siswa terdaftar
        if ($kelas->siswas()->count() > 0) {
            return redirect()
                ->route('kelas.index')
                ->with('error', 'Kelas tidak bisa dihapus karena masih memiliki siswa!');
        }

        $kelas->delete();

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Kelas berhasil dihapus!');
    }
}
