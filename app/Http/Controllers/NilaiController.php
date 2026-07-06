<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    /**
     * index() — Daftar semua nilai dengan filter
     * GET /nilai
     */
    public function index(Request $request)
    {
        $query = Nilai::with(['siswa.kelas']);

        // Filter berdasarkan siswa
        if ($request->filled('siswa_id')) {
            $query->where('siswa_id', $request->siswa_id);
        }

        // Filter berdasarkan semester
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        // Filter berdasarkan tahun ajaran
        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }

        // Filter berdasarkan mata pelajaran
        if ($request->filled('kode_mapel')) {
            $query->where('kode_mapel', $request->kode_mapel);
        }

        $nilais      = $query->orderBy('tahun_ajaran', 'desc')
            ->orderBy('semester')
            ->paginate(15)
            ->withQueryString();

        $siswas      = Siswa::orderBy('nama')->get();
        $mataPelajarans = Nilai::select('kode_mapel', 'nama_mapel')->distinct()->orderBy('nama_mapel')->get();

        return view('nilai.index', compact('nilais', 'siswas', 'mataPelajarans'));
    }

    /**
     * create() — Form tambah nilai
     * GET /nilai/create
     * Bisa menerima query param ?siswa_id=X untuk pre-fill siswa
     */
    public function create(Request $request)
    {
        $siswas = Siswa::with('kelas')
            ->orderBy('nama')
            ->get();

        // Pre-select siswa jika dikirim via query string
        $selectedSiswa = $request->filled('siswa_id')
            ? Siswa::find($request->siswa_id)
            : null;

        $mataPelajarans = $this->daftarMataPelajaran();

        return view('nilai.create', compact('siswas', 'selectedSiswa', 'mataPelajarans'));
    }

    /**
     * store() — Simpan nilai baru
     * POST /nilai
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id'    => 'required|exists:siswas,id',
            'kode_mapel'  => 'required|string|max:10',
            'nama_mapel'  => 'required|string|max:100',
            'nilai_angka' => 'required|numeric|min:0|max:100',
            'semester'    => 'required|in:Ganjil,Genap',
            'tahun_ajaran' => 'required|string|max:10',
        ]);

        // Cegah duplikat: siswa tidak boleh punya nilai mata pelajaran
        // yang sama di semester dan tahun ajaran yang sama
        $duplikat = Nilai::where('siswa_id',    $validated['siswa_id'])
            ->where('kode_mapel',  $validated['kode_mapel'])
            ->where('semester',    $validated['semester'])
            ->where('tahun_ajaran', $validated['tahun_ajaran'])
            ->exists();

        if ($duplikat) {
            return back()
                ->withInput()
                ->withErrors([
                    'kode_mapel' => 'Siswa ini sudah memiliki nilai untuk mata pelajaran yang sama di semester dan tahun ajaran yang sama.'
                ]);
        }

        // Konversi nilai angka ke huruf secara otomatis
        $validated['nilai_huruf'] = Nilai::konversiHuruf($validated['nilai_angka']);

        Nilai::create($validated);

        return redirect()
            ->route('nilai.index')
            ->with('success', 'Nilai berhasil ditambahkan!');
    }

    /**
     * show() — Detail nilai
     * GET /nilai/{nilai}
     */
    public function show(Nilai $nilai)
    {
        $nilai->load('siswa.kelas');
        return view('nilai.show', compact('nilai'));
    }

    /**
     * edit() — Form edit nilai
     * GET /nilai/{nilai}/edit
     */
    public function edit(Nilai $nilai)
    {
        $siswas         = Siswa::with('kelas')->orderBy('nama')->get();
        $mataPelajarans = $this->daftarMataPelajaran();
        $nilai->load('siswa');

        return view('nilai.edit', compact('nilai', 'siswas', 'mataPelajarans'));
    }

    /**
     * update() — Perbarui nilai
     * PUT /nilai/{nilai}
     */
    public function update(Request $request, Nilai $nilai)
    {
        $validated = $request->validate([
            'siswa_id'    => 'required|exists:siswas,id',
            'kode_mapel'  => 'required|string|max:10',
            'nama_mapel'  => 'required|string|max:100',
            'nilai_angka' => 'required|numeric|min:0|max:100',
            'semester'    => 'required|in:Ganjil,Genap',
            'tahun_ajaran' => 'required|string|max:10',
        ]);

        // Cegah duplikat kecuali record ini sendiri
        $duplikat = Nilai::where('siswa_id',    $validated['siswa_id'])
            ->where('kode_mapel',  $validated['kode_mapel'])
            ->where('semester',    $validated['semester'])
            ->where('tahun_ajaran', $validated['tahun_ajaran'])
            ->where('id', '!=', $nilai->id)   // kecualikan record ini
            ->exists();

        if ($duplikat) {
            return back()
                ->withInput()
                ->withErrors(['kode_mapel' => 'Duplikat nilai untuk mata pelajaran, semester, dan tahun ajaran yang sama.']);
        }

        // Konversi ulang nilai huruf
        $validated['nilai_huruf'] = Nilai::konversiHuruf($validated['nilai_angka']);

        $nilai->update($validated);

        return redirect()
            ->route('nilai.index')
            ->with('success', 'Nilai berhasil diperbarui!');
    }

    /**
     * destroy() — Hapus nilai
     * DELETE /nilai/{nilai}
     */
    public function destroy(Nilai $nilai)
    {
        $siswaId = $nilai->siswa_id;
        $nilai->delete();

        return redirect()
            ->route('siswa.show', $siswaId)
            ->with('success', 'Nilai berhasil dihapus!');
    }

    /**
     * Helper: Daftar mata pelajaran tersedia (untuk dropdown form)
     */
    private function daftarMataPelajaran(): array
    {
        return [
            ['kode' => 'MTK01', 'nama' => 'Matematika'],
            ['kode' => 'BIN01', 'nama' => 'Bahasa Indonesia'],
            ['kode' => 'BIG01', 'nama' => 'Bahasa Inggris'],
            ['kode' => 'FIS01', 'nama' => 'Fisika'],
            ['kode' => 'KIM01', 'nama' => 'Kimia'],
            ['kode' => 'BIO01', 'nama' => 'Biologi'],
            ['kode' => 'SEJ01', 'nama' => 'Sejarah'],
            ['kode' => 'PKN01', 'nama' => 'Pendidikan Kewarganegaraan'],
            ['kode' => 'SEN01', 'nama' => 'Seni Budaya'],
            ['kode' => 'PJK01', 'nama' => 'Pendidikan Jasmani'],
        ];
    }
}
