<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthenticatedSessionController extends Controller
{
    // FORM LOGIN SISWA
    public function createSiswa() {
        return view('auth.login-siswa');
    }

    // FORM LOGIN GURU
    public function createGuru() {
        return view('auth.login-guru');
    }

    // LOGIN SISWA
    public function storeSiswa(Request $request) {
        $credentials = $request->validate([
            'nis' => ['required','string'],
            'password' => ['required','string'],
        ]);

        if(Auth::attempt(array_merge($credentials, ['role'=>'siswa']))) {
            $request->session()->regenerate();
            return redirect()->route('siswa.dashboard');
        }

        return back()->withErrors(['nis'=>'NIS atau password salah.']);
    }

    // LOGIN GURU
    public function storeGuru(Request $request) {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required','string'],
        ]);

        if(Auth::attempt(array_merge($credentials, ['role'=>'guru']))) {
            $request->session()->regenerate();
            return redirect()->route('guru.exams.index');
        }

        return back()->withErrors(['email'=>'Email atau password salah.']);
    }

    // LOGOUT
    public function destroy(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
