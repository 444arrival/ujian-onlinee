<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Tampilkan semua soal untuk ujian tertentu.
     */
    public function index(Exam $exam)
    {
        $questions = $exam->questions;
        return view('guru.questions.index', compact('exam', 'questions'));
    }

    /**
     * Tampilkan form untuk membuat soal baru.
     */
    public function create(Exam $exam)
    {
        return view('guru.questions.create', compact('exam'));
    }

    /**
     * Simpan soal baru.
     */
    public function store(Request $request, Exam $exam)
    {
        $request->validate([
            'question_text' => 'required|string',
            'type' => 'required|in:pg,essay',
            'options' => 'nullable|array',
            'answer_key_pg' => 'nullable|string',
            'answer_key_essay' => 'nullable|string',
        ]);

        Question::create([
            'exam_id' => $exam->id,
            'question' => $request->question_text,
            'type' => $request->type,
            'options' => $request->type === 'pg' ? $request->options : null,
            'answer_key_pg' => $request->type === 'pg' ? $request->answer_key_pg : null,
            'answer_key_essay' => $request->type === 'essay' ? $request->answer_key_essay : null,
        ]);

        return redirect()
            ->route('guru.questions.index', $exam->id)
            ->with('success', 'Soal berhasil ditambahkan!');
    }

    /**
     * Tampilkan form untuk edit soal.
     */
    public function edit(Exam $exam, Question $question)
    {
        return view('guru.questions.edit', compact('exam', 'question'));
    }

    /**
     * Update soal.
     */
    public function update(Request $request, Exam $exam, Question $question)
    {
        $request->validate([
            'question_text' => 'required|string',
            'type' => 'required|in:pg,essay',
            'options' => 'nullable|array',
            'answer_key_pg' => 'nullable|string',
            'answer_key_essay' => 'nullable|string',
        ]);

        $question->update([
            'question' => $request->question_text,
            'type' => $request->type,
            'options' => $request->type === 'pg' ? $request->options : null,
            'answer_key_pg' => $request->type === 'pg' ? $request->answer_key_pg : null,
            'answer_key_essay' => $request->type === 'essay' ? $request->answer_key_essay : null,
        ]);

        return redirect()
            ->route('guru.questions.index', $exam->id)
            ->with('success', 'Soal berhasil diperbarui!');
    }

    /**
     * Hapus soal.
     */
    public function destroy(Exam $exam, Question $question)
    {
        $question->delete();

        return redirect()
            ->route('guru.questions.index', $exam->id)
            ->with('success', 'Soal berhasil dihapus!');
    }
}
