<?php
// app/Http/Controllers/MahasiswaController.php — versi dengan Form Request

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSiswaRequest;    // ← import Form Request
use App\Http\Requests\UpdateSiswaRequest;   // ← import Form Request
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    /**
     * index() — Daftar siswa dengan filter dan pencarian
     * GET /siswa
     */
    public function index(Request $request)
    {
        $query = Siswa::with('kelas');

        // Filter pencarian nama atau NIS
        if ($request->filled('search')) {
            $query->cari($request->search);   // menggunakan scope dari Bab 4
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter kelas
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        // Filter tahun masuk
        if ($request->filled('tahun_masuk')) {
            $query->where('tahun_masuk', $request->tahun_masuk);
        }

        $siswas = $query->orderBy('nama')->paginate(10)->withQueryString();
        $kelas  = Kelas::orderBy('nama_kelas')->get();

        return view('siswa.index', compact('siswas', 'kelas'));
    }

    /**
     * create() — Form tambah siswa
     * GET /siswa/create
     */
    public function create()
    {
        $kelas = Kelas::where('status', 'aktif')->orderBy('nama_kelas')->get();
        return view('siswa.create', compact('kelas'));
    }

    /**
     * store() — gunakan StoreSiswaRequest
     */
    public function store(StoreSiswaRequest $request)  // ← Form Request sebagai type-hint
    {
        // $request->validated() hanya berisi data yang sudah divalidasi
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto-siswa', 'public');
        }

        Siswa::create($data);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan!');
    }

    /**
     * show() — Detail siswa beserta nilai-nilainya
     * GET /siswa/{siswa}
     */
    public function show(Siswa $siswa)
    {
        // Eager load relasi yang dibutuhkan di halaman detail
        $siswa->load(['kelas', 'nilais' => function ($q) {
            $q->orderBy('tahun_ajaran', 'desc')->orderBy('semester');
        }]);

        return view('siswa.show', compact('siswa'));
    }

    /**
     * edit() — Form edit siswa
     * GET /siswa/{siswa}/edit
     */
    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::where('status', 'aktif')->orderBy('nama_kelas')->get();
        return view('siswa.edit', compact('siswa', 'kelas'));
    }

    /**
     * update() — gunakan UpdateSiswaRequest
     */
    public function update(UpdateSiswaRequest $request, Siswa $siswa)
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $data['foto'] = $request->file('foto')->store('foto-siswa', 'public');
        }

        $siswa->update($data);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui!');
    }

    /**
     * destroy() — Hapus data siswa
     * DELETE /siswa/{siswa}
     */
    public function destroy(Siswa $siswa)
    {
        // Hapus foto dari storage jika ada
        if ($siswa->foto) {
            Storage::disk('public')->delete($siswa->foto);
        }

        // Data nilai akan ikut terhapus (cascade di migration)
        $siswa->delete();

        return redirect()
            ->route('siswa.index')
            ->with('success', 'Data siswa berhasil dihapus!');
    }
}
