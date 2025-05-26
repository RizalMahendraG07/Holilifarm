<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;  // Pastikan ini ada

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }
    public function showLupaKatasandi()
    {
        return view('admin.LupaKatasandi');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/grafik');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }
    public function logout()
    {
        Auth::logout();  
        return redirect('/login')->with('success', 'You have been logged out successfully.');
    }
}
