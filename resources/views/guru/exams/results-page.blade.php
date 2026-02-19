@extends('layouts.guru')

@section('title','Hasil Ujian')

@section('content')

<div class="card dashboard-card">


    <div class="card-body">

        <form method="GET" action="{{ route('guru.exams.results.page') }}">
            <div class="mb-3">
                <label class="form-label">Pilih Ujian</label>

                <select name="exam_id"
                        class="form-select"
                        onchange="this.form.submit()">

                    <option value="">-- Pilih Ujian --</option>

                    @foreach($exams as $exam)
                        <option value="{{ $exam->id }}"
                            {{ request('exam_id') == $exam->id ? 'selected' : '' }}>

                            {{ $exam->subject->name ?? '-' }}
                            - {{ $exam->title }}

                        </option>
                    @endforeach

                </select>
            </div>
        </form>

    </div>
</div>


{{-- ✅ TABEL MUNCUL DI BAWAH DROPDOWN --}}
@if(!empty($results) && count($results) > 0)

<div class="card dashboard-card mt-4">
    <div class="card-header card-header-custom">
        Hasil Ujian :
        {{ $selectedExam->subject->name ?? '-' }}
        - {{ $selectedExam->title ?? '' }}
    </div>

    <div class="card-body">

        {{-- EXPORT BUTTON --}}
        @if(request('exam_id'))
        <div class="mb-3 text-end">
            <a href="{{ route('guru.exams.export', request('exam_id')) }}"
               class="btn btn-success">
               Export Excel
            </a>
        </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIS</th>
                        <th>Nilai</th>
                        <th width="170" class="text-center">Jawaban Siswa</th>

                    </tr>
                </thead>

                <tbody>
                    @forelse($results as $i => $row)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $row->student->name ?? '-' }}</td>
                            <td>{{ $row->student->nis ?? '-' }}</td>
                            <td>{{ $row->total_score ?? 0 }}</td>
                            <td class="text-center">
    <a href="{{ route('guru.exams.studentResult', [$selectedExam->id, $row->student->id]) }}"
       class="btn btn-sm btn-outline-primary">
        👁 Lihat
    </a>
</td>


                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">
                                Belum ada hasil
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>

@endif

@endsection
