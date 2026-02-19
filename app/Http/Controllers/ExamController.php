<?php

namespace App\Http\Controllers;


use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExamResultsExport;


use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Result;


class ExamController extends Controller
{
    public function index()
    {   
        $exams = Exam::with('subject')
            ->where('teacher_id', Auth::id())
            ->latest()
            ->get();

        return view('guru.exams.index', compact('exams'));
    }

    public function create()
    {
        $subjects = Subject::all();
        return view('guru.exams.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'title'      => 'required|string|max:255',
            'start_time' => 'required|date',
            'duration'   => 'required|integer|min:1',
        ]);

        $end_time = Carbon::parse($request->start_time)
            ->addMinutes((int) $request->duration);

        Exam::create([
            'teacher_id' => Auth::id(),
            'subject_id' => $request->subject_id,
            'title'      => $request->title,
            'start_time' => $request->start_time,
            'end_time'   => $end_time,
            'duration'   => (int) $request->duration,
            'is_active'  => false,
        ]);

        return redirect()
            ->route('guru.exams.index')
            ->with('success', 'Ujian berhasil dibuat!');
    }

    public function edit(Exam $exam)
    {
        $subjects = Subject::all();
        return view('guru.exams.edit', compact('exam', 'subjects'));
    }

    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'title'      => 'required|string|max:255',
            'start_time' => 'required|date',
            'duration'   => 'required|integer|min:1',
        ]);

        $end_time = Carbon::parse($request->start_time)
            ->addMinutes((int) $request->duration);

        $exam->update([
            'subject_id' => $request->subject_id,
            'title'      => $request->title,
            'start_time' => $request->start_time,
            'end_time'   => $end_time,
            'duration'   => (int) $request->duration,
        ]);

        return redirect()
            ->route('guru.exams.index')
            ->with('success', 'Ujian berhasil diperbarui!');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();

        return redirect()
            ->route('guru.exams.index')
            ->with('success', 'Ujian berhasil dihapus!');
    }

    public function activate(Exam $exam)
    {

        if ($exam->questions()->count() === 0) {
            return back()->with(
                'error',
                'Ujian tidak bisa diaktifkan karena soal belum dibuat.'
            );
        }

        $exam->update([
            'is_active' => true
        ]);

        return back()->with(
            'success',
            'Ujian berhasil diaktifkan dan kini tampil untuk siswa.'
        );
    }

    public function results($examId)
    {
        $exam = Exam::findOrFail($examId);

        $results = \App\Models\Result::where('exam_id', $examId)
            ->with('student:id,name,nis')
            ->get();


        return view('guru.exams.results', compact('exam', 'results'));
    }

    public function showStudentResult($examId, $studentId)
    {
        $exam = Exam::findOrFail($examId);

        $answers = \App\Models\Answer::where('exam_id', $examId)
                    ->where('student_id', $studentId)
                    ->with('question')
                    ->get();

        $student = \App\Models\User::findOrFail($studentId);

        return view('guru.exams.student-detail', compact('exam', 'answers', 'student'));
    }


public function resultsPage(Request $request)
{
    $teacherId = auth()->id();

    $exams = Exam::with('subject')
                ->where('teacher_id', $teacherId)
                ->get();

    $selectedExam = null;
    $results = [];

    if ($request->exam_id) {

        $selectedExam = Exam::with('subject')
                            ->find($request->exam_id);

        $results = \App\Models\Result::with('student')
                    ->where('exam_id', $request->exam_id)
                    ->get();
    }

    return view('guru.exams.results-page', compact(
        'exams',
        'results',
        'selectedExam'
    ));
}


public function export($examId)
{
    return Excel::download(
        new ExamResultsExport($examId),
        'hasil-ujian.xlsx'
    );
}




}
