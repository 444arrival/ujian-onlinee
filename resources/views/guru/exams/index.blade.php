@extends('layouts.guru')

@section('title', 'Daftar Ujian')

<style>
    .table-responsive {
        overflow: visible !important;
    }

    .table td,
    .table th {
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background: #f8fafc;
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
        min-width: 95px;
        text-align: center;
    }

    .status-belum {
        background: #e2e8f0;
        color: #475569;
    }

    .status-aktif {
        background: #22c55e;
        color: white;
    }

    .status-selesai {
        background: #ef4444;
        color: white;
    }

    .aksi-btns {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        flex-wrap: nowrap;
    }

    .aksi-btns form {
        margin: 0;
    }

    .aksi-btns .btn {
        font-size: 13px;
        font-weight: 500;
        padding: 6px 12px;
        border-radius: 8px;
        white-space: nowrap;
    }
</style>

@section('content')
<div class="card shadow-sm">

    {{-- HEADER --}}
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold">Daftar Ujian</h5>

        <a href="{{ route('guru.exams.create') }}" class="btn btn-primary btn-sm">
            + Judul Ujian
        </a>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                {{-- HEADER TABLE --}}
                <thead class="table-light">
                    <tr>
                        <th width="50">No</th>
                        <th>Mata Pelajaran</th>
                        <th>Judul</th>
                        <th width="180">Mulai</th>
                        <th width="120" class="text-center">Status</th>
                        <th width="280" class="text-center">Aksi</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody>
                @forelse($exams as $i => $exam)

                    @php
                        $now = now();
                        $start = \Carbon\Carbon::parse($exam->start_time);
                        $end = $start->copy()->addHours(2);
                    @endphp

                    <tr>
                        <td>{{ $i+1 }}</td>

                        <td>{{ $exam->subject->name ?? '-' }}</td>

                        <td class="fw-semibold">
                            {{ $exam->title }}
                        </td>

                        <td>{{ $start->format('d M Y H:i') }}</td>

                        {{-- STATUS LEBIH RAPI --}}
                        <td class="text-center">
                            @if($now->lt($start))
                                <span class="status-badge status-belum">
                                    Belum
                                </span>

                            @elseif($now->between($start,$end))
                                <span class="status-badge status-aktif">
                                    Berlangsung
                                </span>

                            @else
                                <span class="status-badge status-selesai">
                                    Selesai
                                </span>
                            @endif
                        </td>

                        {{-- AKSI --}}
                        <td class="text-center">
                            <div class="aksi-btns">

                                <a href="{{ route('guru.questions.index',$exam->id) }}"
                                   class="btn btn-info text-white">
                                    📝 Buat Soal
                                </a>

                                <a href="{{ route('guru.exams.edit',$exam->id) }}"
                                   class="btn btn-warning">
                                    ✏️ Edit
                                </a>

                                <form method="POST"
                                      action="{{ route('guru.exams.destroy',$exam->id) }}"
                                      onsubmit="return confirm('Hapus ujian ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger">
                                        🗑️ Hapus
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            Belum ada ujian
                        </td>
                    </tr>
                @endforelse

                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection
