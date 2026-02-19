<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    // FORM REGISTER SISWA
    public function createSiswa() {
        return view('auth.register-siswa');
    }

    // PROSES REGISTER SISWA
    public function storeSiswa(Request $request) {
        $request->validate([
            'nis'=>'required|string|unique:users,nis',
            'name'=>'required|string|max:255',
            'password'=>'required|string|min:6|confirmed'
        ]);

        $user = User::create([
            'nis'=>$request->nis,
            'name'=>$request->name,
            'password'=>Hash::make($request->password),
            'role'=>'siswa'
        ]);

        return redirect()
        ->route('login.siswa')
        ->with('success', 'Akun berhasil dibuat, silakan masuk');

        return redirect()->route('siswa.dashboard')->with('success','Pendaftaran berhasil!');
    }
}
