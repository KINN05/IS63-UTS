<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Nilai;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKelas   = Kelas::count();
        $totalSiswa   = Siswa::count();
        $totalNilai   = Nilai::count();
        $siswaTerbaru = Siswa::with('kelas')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalKelas',
            'totalSiswa',
            'totalNilai',
            'siswaTerbaru'
        ));
    }
}
