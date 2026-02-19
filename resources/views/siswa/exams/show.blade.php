@extends('layouts.app')

@push('styles')
<style>
    body {
        background: #f5f6fa;
        font-family: 'Poppins', sans-serif;
    }

    .timer-container {
        display: flex;
        justify-content: center;
        gap: 8px;
        font-weight: 600;
        margin-bottom: 20px;
    }

    .timer {
        color: #333;
        font-size: 1.2rem;
    }

    .timer.red {
        color: #ff4e4e;
    }

    .card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 12px;
    }

    .card-body {
        padding: 12px;
    }

    .card-body strong {
        display: block;
        margin-bottom: 8px;
        color: #333;
    }

    .form-check {
        border: 1px solid #ccc;
        border-radius: 6px;
        padding: 8px;
        margin-bottom: 6px;
        cursor: pointer;
        background: #fafafa;
    }

    .form-check:hover {
        background: #f0f0f0;
    }

    .form-check-input:checked + .form-check-label {
        font-weight: 600;
        color: #2e7d32;
    }

    textarea.form-control {
        width: 100%;
        border: 1px solid #ccc;
        border-radius: 6px;
        padding: 6px;
        min-height: 80px;
        resize: vertical;
    }

    textarea:focus {
        outline: none;
        border-color: #2e7d32;
    }

    .btn-simple {
        width: 100%;
        padding: 10px;
        border: 1px solid #2e7d32;
        border-radius: 6px;
        background: #fff;
        color: #2e7d32;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-simple:hover {
        background: #f0f0f0;
    }


    @media (max-width: 575px) {
        .timer { font-size: 1rem; }
        .card-body strong { font-size: 0.95rem; }
        .form-check { font-size: 0.9rem; padding: 6px; }
        textarea.form-control { font-size: 0.9rem; }
        .btn-simple { font-size: 0.95rem; padding: 8px; }
    }
</style>
@endpush


@section('content')
<div class="container mt-4">

    <div class="timer-container">
        <span>Waktu Tersisa:</span>
        <span id="timer" class="timer"></span>
    </div>

    <form
        id="examForm"
        method="POST"
        action="{{ route('siswa.exams.submit', $exam->id) }}">
        @csrf


        @foreach($questions as $index => $question)

            <div class="card">
                <div class="card-body">

                    <strong>
                        {{ $index + 1 }}. {{ $question->question }}
                    </strong>

                    @if($question->type == 'pg')

                        @php
                            $options = is_array($question->options)
                                ? $question->options
                                : json_decode($question->options, true);
                        @endphp

                        @if(is_array($options))
                            @foreach($options as $key => $option)

                                <div class="form-check">
                                    <input
                                        class="form-check-input" type="radio" name="answers[{{ $question->id }}]"
                                        id="q{{ $question->id }}_{{ $key }}"value="{{ $key }}" required>

                                    <label class="form-check-label" for="q{{ $question->id }}_{{ $key }}">
                                        {{ $key }}. {{ $option }}
                                    </label>
                                </div>

                            @endforeach
                        @endif

                    @else
                        <textarea
                            name="answers[{{ $question->id }}]"
                            class="form-control mt-2"
                            placeholder="Ketik jawabanmu di sini..."
                            required
                        ></textarea>
                    @endif

                </div>
            </div>

        @endforeach


        <button type="submit" class="btn-simple mt-3">
            Kirim Jawaban
        </button>

    </form>
</div>


{{-- SCRIPT --}}
<script>
    let duration = {{ (int) $durationLeft }};
    const timerDisplay = document.getElementById('timer');
    const form = document.getElementById('examForm');

    function formatTime(seconds) {
        const m = Math.floor(seconds / 60).toString().padStart(2, '0');
        const s = (seconds % 60).toString().padStart(2, '0');
        return `${m}:${s}`;
    }

    function updateTimer() {
        timerDisplay.textContent = formatTime(duration);

        // <= 5 menit → merah
        if (duration <= 5 * 60) {
            timerDisplay.classList.add('red');
        }

        if (duration <= 0) {
            clearInterval(countdown);
            alert('⏰ Waktu habis! Jawabanmu dikirim otomatis.');
            form.submit();
        }

        duration--;
    }

    const countdown = setInterval(updateTimer, 1000);
    updateTimer();
</script>
@endsection
