<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request) {
        $credentials = $request->validate([
            'email'=>'required|email',
            'password'=> 'required'
        ]);

        if(Auth::guard('peminjam')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/dashboard');
        };

        return back()->withErrors([
            'email'=>'Login Gagal'
        ]);
    }
}
