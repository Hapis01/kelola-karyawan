<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login
    public function loginProcess(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'password.required' => 'Password harus diisi'
        ]);

        $credentials = $request->only('email', 'password');

        // Check if email exists
        $user = \App\Models\User::where('email', $credentials['email'])->first();
        
        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan. Periksa kembali email Anda.')->withInput($request->only('email'));
        }

        // Try to authenticate
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Jika user adalah admin (tidak punya relasi karyawan), arahkan ke admin dashboard
            if (!$user->karyawan_id) {
                return redirect()->route('admin.dashboard');
            }
            
            // Jika user punya relasi karyawan, arahkan ke karyawan dashboard
            return redirect()->route('karyawan.dashboard');
        }

        return back()->with('error', 'Password yang Anda masukkan salah. Silahkan coba lagi.')->withInput($request->only('email'));
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
