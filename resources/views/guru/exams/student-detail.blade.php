@extends('layouts.guru')

@section('title', 'Detail Jawaban Siswa')

@section('content')

<div class="card dashboard-card">

    <div class="card-header card-header-custom d-flex justify-content-between align-items-center flex-wrap">
        <h5 class="mb-0">
            📑 Detail Jawaban: {{ $student->name }}
        </h5>

        <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm mt-2 mt-md-0">
            ⬅️ Kembali
        </a>
    </div>

    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <table class="table table-borderless table-sm">
                    <tr>
                        <td width="35%" class="text-muted">Nama Siswa</td>
                        <td>: <strong>{{ $student->name }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Mata Pelajaran</td>
                        <td>: {{ $exam->subject->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Judul Ujian</td>
                        <td>: {{ $exam->title }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th>Pertanyaan</th>
                        <th width="20%">Jawaban Siswa</th>
                        <th width="20%">Kunci Jawaban</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($answers as $index => $answer)
                        @php
                            $isCorrect = $answer->answer === $answer->question->answer_key_pg;
                        @endphp
                        <tr>
                            <td class="text-center text-muted">{{ $index + 1 }}</td>
                            <td>
                                <div class="px-2">
                                    {!! $answer->question->question !!}
                                </div>
                            </td>
                            <td class="text-center">
                                @if ($answer->answer)
                                    <span class="badge {{ $isCorrect ? 'bg-success' : 'bg-danger' }} py-2 px-3">
                                        {{ $answer->answer }}
                                    </span>
                                @else
                                    <span class="text-muted italic">Tidak diisi</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark py-2 px-3 border">
                                    {{ $answer->question->answer_key_pg ?? ($answer->question->answer_key_essay ?? '-') }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection