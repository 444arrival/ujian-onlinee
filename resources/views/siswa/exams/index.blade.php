@extends('layouts.app')

@section('title', 'Daftar Ujian')

@section('content')

<style>
    
    body { background: #f7f8fa; }

    .exam-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        margin-bottom: 24px;
    }

    .exam-header {
        background: #4e73df;
        color: white;
        padding: 16px 20px;
        font-size: 1.25rem;
        font-weight: 600;
    }

    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 6px;
        margin-top: 12px;
    }

    thead th {
        background-color: #f3f4f6; 
        color: #374151; 
        padding: 12px 16px;
        font-size: 0.9rem;
        text-transform: uppercase;
        font-weight: 600;
        text-align: center;
        border-bottom: 2px solid #e5e7eb; 
        border-radius: 6px 6px 0 0; 
    }


    tbody td {
        background: #fff;
        padding: 12px;
        font-size: 0.9rem;
        border-radius: 6px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .btn-start {
        padding: 6px 12px;
        background: #2563eb;
        color: white;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: 0.3s;
    }
    .btn-start:hover { background: #1d4ed8; }

    .status-done {
        padding: 4px 10px;
        background: #d1e7dd;
        color: #0f5132;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .status-wait {
        padding: 4px 10px;
        background: #e2e3e5;
        color: #6c757d;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .score-badge {
        padding: 4px 10px;
        background: #d1e7dd;
        color: #0f5132;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .score-empty { color: #6c757d; font-weight: 500; }

    @media (max-width: 768px) {
        table thead { display: none; }
        table tbody tr {
            display: block;
            margin-bottom: 12px;
        }
        table tbody td {
            display: flex;
            justify-content: space-between;
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #4e73df;
        }
        table tbody td:last-child { border-bottom: none; }
    }
</style>

<div class="exam-card">
    <div class="exam-header">📚 Daftar Ujian Kamu</div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Mapel</th>
                        <th>Judul</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($exams as $index => $exam)
                        @php
                            $examDate = $exam->start_time
                                ? \Carbon\Carbon::parse($exam->start_time)->format('d M Y')
                                : '-';
                        @endphp
                        <tr>
                            <td data-label="#">{{ $index + 1 }}</td>
                            <td data-label="Mapel" class="fw-semibold text-dark">{{ $exam->subject->name ?? '-' }}</td>
                            <td data-label="Judul">{{ $exam->title }}</td>
                            <td data-label="Tanggal">{{ $examDate }}</td>
                            <td data-label="Aksi">
                        @php
                            $now = now();
                            $start = \Carbon\Carbon::parse($exam->start_time);
                            $end = $start->copy()->addMinutes($exam->duration);
                        @endphp

                        @if($exam->already_done)
                            <span class="status-done">Selesai</span>
                        @elseif($now->lt($start))
                            <span class="status-wait">Belum Dimulai</span>
                        @elseif($now->between($start, $end))
                            <a href="{{ route('siswa.exams.show', $exam->id) }}" class="btn-start">
                                Ikuti Ujian
                            </a>
                        @else
                            <span >-</span>
                        @endif
                    </td>

                            <td data-label="Nilai">
                                @if($exam->already_done)
                                    <span class="score-badge">{{ $exam->final_score }}</span>
                                @else
                                    <span class="score-empty">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada ujian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
