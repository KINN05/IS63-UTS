<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Nilai;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKelas     = Kelas::count();
        $totalSiswa     = Siswa::count();
        $totalNilai     = Nilai::count();
        $siswaAktif     = Siswa::where('status', 'aktif')->count();

        $siswaTerbaru   = Siswa::with('kelas')
            ->latest()
            ->take(5)
            ->get();

        $statistikKelas = Kelas::withCount('siswas')
            ->orderByDesc('siswas_count')
            ->get();

        return view('dashboard', compact(
            'totalKelas',
            'totalSiswa',
            'totalNilai',
            'siswaAktif',
            'siswaTerbaru',
            'statistikKelas'
        ));
    }
}
