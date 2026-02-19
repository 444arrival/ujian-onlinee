<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    // 🔐 Form Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 🚪 Proses Login
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $login = $request->input('login');
        $password = $request->input('password');

        // Cari user berdasarkan email (guru/admin) atau NIS (siswa)
        $user = User::where('email', $login)
            ->orWhere('nis', $login)
            ->first();

        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user); 

            // 🔁 Redirect otomatis berdasarkan role
            switch ($user->role) {
                case 'guru':
                    return redirect()->route('guru.exams.index'); // 🧑‍🏫 Guru → daftar ujian
                case 'siswa':
                    return redirect()->route('siswa.exams.index'); // 🎓 Siswa → daftar ujian
                case 'admin':
                    return redirect()->route('dashboard.admin');
                default:
                    Auth::logout();
                    return redirect()->route('login')
                        ->withErrors(['login' => 'Role tidak dikenali.']);
            }
        }

        return back()->withErrors([
            'login' => 'Login gagal, periksa kembali email/NIS dan password.',
        ]);
    }

    // 🚪 Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
