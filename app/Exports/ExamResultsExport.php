<?php

namespace App\Exports;

use App\Models\Result;
use App\Models\Exam;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExamResultsExport implements FromArray, WithHeadings, WithEvents
{
    protected $examId;
    protected $examTitle;
    protected $subject;

    public function __construct($examId)
{
    $this->examId = $examId;

    $exam = Exam::with('subject')->find($examId);

    $this->examTitle = $exam?->title ?? 'Ujian';

    $this->subject = $exam?->subject?->name ?? '-';
}


    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'NIS',
            'Nilai',
        ];
    }


    public function array(): array
    {
        $results = Result::where('exam_id', $this->examId)
            ->with('student')
            ->get();

        $data = [];
        $no = 1;

        foreach ($results as $r) {
            $data[] = [
                $no++,
                $r->student?->name ?? '-',
                $r->student?->nis ?? '-',
                $r->total_score,
            ];
        }

        return $data;
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                $sheet->insertNewRowBefore(1, 3);

                $sheet->setCellValue('A1', 'Hasil Ujian : ' . $this->examTitle);
                $sheet->mergeCells('A1:D1');

                $sheet->setCellValue('A2', 'Mata Pelajaran : ' . $this->subject);
                $sheet->mergeCells('A2:D2');

                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A2')->getFont()->setBold(true);

                $sheet->getStyle('A1:A2')->getAlignment()->setHorizontal('center');

                $sheet->getStyle('A4:D4')->getFont()->setBold(true);

                foreach (range('A', 'D') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}
