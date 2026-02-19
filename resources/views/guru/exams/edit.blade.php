@extends('layouts.guru')

@section('title', 'Edit Ujian')

@section('content')
<div class="card shadow-sm mt-3">
    <div class="card-header bg-primary text-white py-3">
        <h5 class="mb-0 fw-bold">📘 Edit Ujian: {{ $exam->title }}</h5>
    </div>

    <div class="card-body p-4">
        <form action="{{ route('guru.exams.update', $exam->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="fw-bold mb-2">Mata Pelajaran</label>
                    <select name="subject_id" class="form-select">
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ $exam->subject_id == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold mb-2">Judul Ujian</label>
                    <input type="text" name="title" class="form-control" 
                           value="{{ old('title', $exam->title) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold mb-2">Waktu Mulai</label>
                    <input type="datetime-local" name="start_time" class="form-control" 
                           value="{{ old('start_time', date('Y-m-d\TH:i', strtotime($exam->start_time))) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold mb-2">Durasi (Menit)</label>
                    <input type="number" name="duration" class="form-control" 
                           value="{{ old('duration', $exam->duration) }}" required>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('guru.exams.index') }}" class="btn btn-light border px-4">Batal</a>
                <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection