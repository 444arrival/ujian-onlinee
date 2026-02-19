<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'guru') {
            return redirect()->route('guru.exams.index');
        }

        if ($user->role === 'siswa') {
            return redirect()->route('siswa.dashboard');
        }

        return view('dashboard');
    }
}
