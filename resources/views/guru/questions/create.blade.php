@extends('layouts.guru')

@section('title', 'Tambah Soal')

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
            <h5 class="mb-0">Tambah Soal — {{ $exam->title }}</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('guru.questions.store', ['exam' => $exam->id]) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Teks Soal</label>
                    <textarea name="question_text" class="form-control" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Tipe Soal</label>
                    <select name="type" id="type" class="form-select" required>
                        <option value="pg">Pilihan Ganda</option>
                        <option value="essay">Essay</option>
                    </select>
                </div>

                <div id="pg-options" class="mb-3">
                    <label class="form-label fw-semibold">Pilihan Jawaban</label>
                    <input type="text" name="options[A]" class="form-control mb-2" placeholder="Opsi A">
                    <input type="text" name="options[B]" class="form-control mb-2" placeholder="Opsi B">
                    <input type="text" name="options[C]" class="form-control mb-2" placeholder="Opsi C">
                    <input type="text" name="options[D]" class="form-control mb-2" placeholder="Opsi D">

                    <label class="form-label fw-semibold mt-2">Jawaban Benar (PG)</label>
                    <select name="answer_key_pg" class="form-select">
                        <option value="">-- Pilih Jawaban Benar --</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
                </div>

                <div id="essay-key" class="mb-3" style="display:none;">
                    <label class="form-label fw-semibold">Jawaban Kunci Essay</label>
                    <textarea name="answer_key_essay" class="form-control" rows="3"
                        placeholder="Masukkan jawaban kunci essay (digunakan untuk penilaian otomatis)"></textarea>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('guru.questions.index', $exam->id) }}" class="btn btn-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-success">
                        Simpan Soal
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
    toggleOptions(); // initial
</script>
@endsection
