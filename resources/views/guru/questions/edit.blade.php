@extends('layouts.guru')

@section('title', 'Edit Soal')

@section('content')
<style>
    .logout-btn,
    a[href="{{ route('logout') }}"],
    form[action="{{ route('logout') }}"] {
        display: none !important;
    }
</style>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Edit Soal — {{ $exam->title }}</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('guru.questions.update', [$exam->id, $question->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Teks Soal</label>
                    <textarea name="question_text" class="form-control" rows="4" required>{{ $question->question_text }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Tipe Soal</label>
                    <select name="type" id="type" class="form-select" required>
                        <option value="pg" {{ $question->type == 'pg' ? 'selected' : '' }}>Pilihan Ganda</option>
                        <option value="essay" {{ $question->type == 'essay' ? 'selected' : '' }}>Essay</option>
                    </select>
                </div>

                <div id="pg-options" class="mb-3" style="display: {{ $question->type == 'pg' ? 'block' : 'none' }}">
                    <label class="form-label fw-semibold">Pilihan Jawaban</label>
                    @php
                        $options = is_array($question->options) ? $question->options : json_decode($question->options, true) ?? [];
                    @endphp
                    @foreach (['A','B','C','D'] as $key)
                        <input type="text" name="options[{{ $key }}]" class="form-control mb-2" placeholder="Opsi {{ $key }}" value="{{ $options[$key] ?? '' }}">
                    @endforeach

                    <label class="form-label fw-semibold mt-2">Jawaban Benar (PG)</label>
                    <select name="answer_key_pg" class="form-select" required>
                        <option value="">-- Pilih Jawaban Benar --</option>
                        @foreach (['A','B','C','D'] as $key)
                            <option value="{{ $key }}" {{ ($question->answer_key_pg ?? '') == $key ? 'selected' : '' }}>{{ $key }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="essay-key" class="mb-3" style="display: {{ $question->type == 'essay' ? 'block' : 'none' }}">
                    <label class="form-label fw-semibold">Jawaban Kunci Essay</label>
                    <textarea name="answer_key_essay" class="form-control" rows="3" placeholder="Masukkan jawaban kunci essay">{{ $question->answer_key_essay ?? '' }}</textarea>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('guru.questions.index', $exam->id) }}" class="btn btn-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-success">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const typeSelect = document.getElementById('type');
    const pgOptions = document.getElementById('pg-options');
    const essayKey = document.getElementById('essay-key');

    function toggleOptions() {
        if (typeSelect.value === 'pg') {
            pgOptions.style.display = 'block';
            essayKey.style.display = 'none';

            pgOptions.querySelector('select[name="answer_key_pg"]').required = true;
            essayKey.querySelector('textarea[name="answer_key_essay"]').required = false;
        } else {
            pgOptions.style.display = 'none';
            essayKey.style.display = 'block';

            pgOptions.querySelector('select[name="answer_key_pg"]').required = false;
            essayKey.querySelector('textarea[name="answer_key_essay"]').required = true;
        }
    }

    typeSelect.addEventListener('change', toggleOptions);
    toggleOptions(); 
</script>
@endsection
