<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::with('subject')
            ->where('is_active', true)
            ->orderBy('start_time', 'asc')
            ->get();

        return view('siswa.exams.index', compact('exams'));
    }
}
