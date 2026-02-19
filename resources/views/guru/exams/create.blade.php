@extends('layouts.guru')

@section('title', 'Tambah Ujian')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg rounded-3 border-0">
                <div class="card-header bg-success text-white fw-semibold d-flex align-items-center">
                    <i class="bi bi-journal-plus me-2 fs-5"></i> Tambah Ujian Baru
                </div>

                <div class="card-body p-4 bg-light">
                    <form action="{{ route('guru.exams.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Judul Ujian</label>
                            <input type="text" name="title" class="form-control shadow-sm"
                                 required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Mata Pelajaran</label>
                            <select name="subject_id" class="form-select shadow-sm" required>
                                <option value="">-- Pilih Mata Pelajaran --</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tanggal Mulai</label>
                            <input type="datetime-local" name="start_time" class="form-control shadow-sm" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Durasi Ujian (menit)</label>
                            <input type="number" name="duration" class="form-control shadow-sm" min="1" required>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('guru.exams.index') }}" 
                               class="btn btn-outline-secondary me-2">
                               <i class="bi bi-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save2"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
