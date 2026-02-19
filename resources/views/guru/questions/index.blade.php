@extends('layouts.guru')

@section('title', 'Soal Ujian: ' . $exam->title)

@section('content')
<div class="card shadow-sm mt-3">
    <!-- Header -->
    <div class="card-header bg-primary text-white d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
        <h5 class="mb-2 mb-md-0">📘 Soal Ujian: {{ $exam->title }}</h5>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('guru.exams.index') }}" class="btn btn-light btn-sm">← Kembali</a>
            <a href="{{ route('guru.questions.create', $exam->id) }}" class="btn btn-light btn-sm">+ Tambah Soal</a>
        </div>
    </div>

    <!-- Body -->
    <div class="card-body">

        @if($questions->isEmpty())
            <p class="text-muted text-center mt-3">Belum ada soal untuk ujian ini.</p>
        @else
            {{-- DESKTOP TABLE --}}
            <div class="table-responsive table-desktop mt-3 d-none d-md-block">
                <table class="table table-striped table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Pertanyaan</th>
                            <th style="width: 100px;">Tipe</th>
                            <th style="width: 160px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($questions as $index => $question)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="text-start">{{ Str::limit($question->question, 80) }}</td>
                            <td>{{ ucfirst($question->type) }}</td>

                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('guru.questions.edit', [$exam->id, $question->id]) }}"
                                       class="btn btn-warning btn-sm">
                                        ✏️ Edit
                                    </a>

                                    <form action="{{ route('guru.questions.destroy', [$exam->id, $question->id]) }}"
                                          method="POST">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Hapus soal ini?')">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-mobile mt-3 d-block d-md-none">
                @foreach($questions as $index => $question)
                <div class="question-card border p-2 mb-2 rounded shadow-sm">
                    <div class="mb-1"><span class="fw-bold">No:</span> {{ $index + 1 }}</div>
                    <div class="mb-1"><span class="fw-bold">Pertanyaan:</span> {{ $question->question }}</div>
                    <div class="mb-1"><span class="fw-bold">Tipe:</span> {{ ucfirst($question->type) }}</div>
                    <div class="d-flex gap-2 mt-2">
                        <a href="{{ route('guru.questions.edit', [$exam->id, $question->id]) }}"
                           class="btn btn-warning btn-sm flex-fill">
                            ✏️ Edit
                        </a>
                        <form action="{{ route('guru.questions.destroy', [$exam->id, $question->id]) }}"
                              method="POST" class="flex-fill">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm w-100"
                                    onclick="return confirm('Hapus soal ini?')">
                                🗑️ Hapus
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection
