<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // app/Http/Controllers/AuthController.php
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Cek jika yang login adalah admin (Kepala/Pustakawan)
            if (in_array(Auth::user()->role, ['kepala perpustakaan', 'pustakawan'])) {
                return redirect('/dashboard');
            }

            // Jika user lain (Peminjam)
            return redirect('/');
        }

        return back()->with('error', 'Login gagal, periksa kembali akun Anda.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
