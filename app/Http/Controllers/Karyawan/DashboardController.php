<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Karyawan;
use App\Models\KaryawanHistory;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Cek role - hanya karyawan yang bisa akses
        if ($user->role !== 'karyawan') {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses ke halaman karyawan.');
        }
        
        // Jika user tidak punya relasi karyawan, redirect ke login
        if (!$user->karyawan) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'User tidak terhubung dengan data karyawan.');
        }

        $karyawan = $user->karyawan;
        
        // Get history perubahan data karyawan
        $histories = KaryawanHistory::where('karyawan_id', $karyawan->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('karyawan.dashboard', [
            'karyawan' => $karyawan,
            'histories' => $histories,
        ]);
    }

    public function profile()
    {
        $user = Auth::user();
        
        // Cek role
        if ($user->role !== 'karyawan') {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses ke halaman karyawan.');
        }
        
        $karyawan = $user->karyawan;

        return view('karyawan.profile', [
            'karyawan' => $karyawan,
        ]);
    }

    public function generateIDCard($nik)
    {
        $user = Auth::user();
        
        // Cek role
        if ($user->role !== 'karyawan') {
            abort(403, 'Unauthorized');
        }
        
        // Cek apakah user ini adalah pemilik karyawan tersebut (berdasarkan NIK)
        if ($user->nik !== $nik) {
            abort(403, 'Unauthorized');
        }

        $karyawan = \App\Models\Karyawan::where('nik', $nik)->with('divisi')->firstOrFail();

        // Generate PDF ID Card
        $pdf = \PDF::loadView('karyawan.id-card', [
            'karyawan' => $karyawan,
        ])
        ->setPaper('a4', 'landscape')
        ->setOption('margin-top', 5)
        ->setOption('margin-right', 5)
        ->setOption('margin-bottom', 5)
        ->setOption('margin-left', 5)
        ->setOption('dpi', 300);

        return $pdf->stream('kartu-karyawan-' . $karyawan->nik . '.pdf');
    }
}
