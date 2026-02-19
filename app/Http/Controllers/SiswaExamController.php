<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SiswaExamController extends Controller
{
    public function index()
{
    $user = Auth::user();

    $exams = Exam::with('subject')
        ->orderBy('start_time', 'desc')
        ->get()
        ->map(function ($exam) use ($user) {

            $result = Result::where('exam_id', $exam->id)
                ->where('student_id', $user->id)
                ->first();

            $exam->already_done = $result !== null;
            $exam->final_score  = $result?->total_score; 

            return $exam;
        });

    return view('siswa.exams.index', compact('exams'));
}


    public function show(Exam $exam)
    {
        $user = Auth::user();
        $now = Carbon::now();

        $start = Carbon::parse($exam->start_time);
        $globalEnd = $start->copy()->addMinutes($exam->duration);

        if ($now->lt($start) || $now->gt($globalEnd)) {
    return redirect()
        ->route('siswa.exams.index')
        ->with('error', 'Ujian sudah ditutup.');
}

        $alreadyDone = Answer::where('exam_id', $exam->id)
            ->where('student_id', $user->id)
            ->exists();

        if ($alreadyDone) {
            return redirect()
                ->route('siswa.exams.index')
                ->with('info', 'Kamu sudah mengerjakan ujian ini dan tidak bisa mengulang.');
        }

        $result = Result::firstOrCreate(
            [
                'exam_id' => $exam->id,
                'student_id' => $user->id
            ],
            [
                'total_score' => 0,
                'status' => 'belum',
                'start_time' => now()
            ]
        );

        $durationLeft = max(
            0,
            ($exam->duration * 60) - now()->diffInSeconds($result->start_time)
        );

        $questions = $exam->questions;

        return view('siswa.exams.show', compact('exam', 'questions', 'durationLeft'));
    }

    public function submit(Request $request, Exam $exam)
    {
        $user = Auth::user();

        $alreadyDone = Answer::where('exam_id', $exam->id)
            ->where('student_id', $user->id)
            ->exists();

        if ($alreadyDone) {
            return redirect()
                ->route('siswa.exams.index')
                ->with('info', 'Kamu sudah mengerjakan ujian ini.');
        }

        $answers = $request->input('answers', []);
        $scores = [];

        foreach ($answers as $question_id => $answer_value) {
            $question = Question::find($question_id);
            if (!$question) continue;

            $score = 0;
            $studentAnswerToSave = $answer_value;

            // PENILAIAN
            if ($question->type === 'pg') {
                $score = ($answer_value === $question->answer_key_pg) ? 10 : 0;
            } elseif ($question->type === 'essay') {

                $studentText = trim($answer_value);
                $correctText = trim($question->answer_key_essay ?? '');

                if ($correctText === '') {
                    $score = 0;
                } else {
                    similar_text(
                        mb_strtolower($studentText),
                        mb_strtolower($correctText),
                        $percent
                    );

                    // maksimal 10
                    $score = round(($percent / 100) * 10, 2);
                }

                $studentAnswerToSave = $studentText;
            }

            Answer::updateOrCreate(
                [
                    'exam_id' => $exam->id,
                    'question_id' => $question->id,
                    'student_id' => $user->id
                ],
                [
                    'answer' => $studentAnswerToSave,
                    'score' => $score
                ]
            );

            $scores[] = $score;
        }

        $totalScore = array_sum($scores);
        $maxScore   = count($scores) * 10;

        $finalScore = $maxScore > 0
    ? round(($totalScore / $maxScore) * 100, 2)
    : 0;


        Result::updateOrCreate(
            [
                'exam_id' => $exam->id,
                'student_id' => $user->id
            ],
            [
                'total_score' => $finalScore,
                'status' => 'selesai'
            ]
        );

        return redirect()
            ->route('siswa.exams.index')
            ->with('success', 'Jawaban berhasil dikirim! Nilai sudah dihitung.');
    }
}
