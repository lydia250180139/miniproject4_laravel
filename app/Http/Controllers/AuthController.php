<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan portal login Administrator.
     */
    public function showAdmin()
    {
        return view('auth.login-admin');
    }

    /**
     * Proses autentikasi khusus Administrator.
     */
    public function loginAdmin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            // Cek role: Hanya admin yang boleh login di portal ini
            if (! $user->isAdmin()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()
                    ->withInput($request->only('username'))
                    ->withErrors(['username' => 'Akses Terlarang! Akun ini bertipe Staff. Anda dilarang masuk melalui Portal Admin. Silakan gunakan Portal Staff.']);
            }

            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'))->with('success', 'Selamat datang kembali, Administrator ' . $user->name . '!');
        }

        return back()
            ->withInput($request->only('username'))
            ->withErrors(['username' => 'Username atau password Administrator tidak cocok.']);
    }

    /**
     * Tampilkan portal login Staff.
     */
    public function showStaff()
    {
        return view('auth.login-staff');
    }

    /**
     * Proses autentikasi khusus Staff.
     */
    public function loginStaff(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            // Cek role: Hanya staff yang boleh login di portal ini
            if (! $user->isStaff()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()
                    ->withInput($request->only('username'))
                    ->withErrors(['username' => 'Akses Terlarang! Akun ini adalah Administrator. Silakan gunakan Portal Administrator.']);
            }

            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'))->with('success', 'Selamat datang, Staff ' . $user->name . '!');
        }

        return back()
            ->withInput($request->only('username'))
            ->withErrors(['username' => 'Username atau password Staff tidak cocok.']);
    }

    /**
     * Keluar dari aplikasi.
     */
    public function logout(Request $request)
    {
        $role = Auth::user()?->role;
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route($role === 'staff' ? 'login.staff' : 'login.admin')
            ->with('success', 'Anda telah berhasil keluar.');
    }
}
