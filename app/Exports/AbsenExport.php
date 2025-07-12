<?php

namespace App\Exports;

use App\Models\Absen;
use App\Models\User;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class AbsenExport implements FromArray, WithEvents
{
    protected $tanggalList;

    public function __construct()
    {
        // Ambil semua tanggal unik dari sesi absen yang tersedia
        $this->tanggalList = Absen::with('sesi')
            ->get()
            ->pluck('sesi')
            ->filter()
            ->pluck('tanggal')
            ->unique()
            ->sort()
            ->values();
    }

    public function array(): array
    {
        $data = [];

        // Baris header ke-2 (baris 2 di Excel)
        $header1 = ['Nama'];
        foreach ($this->tanggalList as $tanggal) {
            $header1[] = Carbon::parse($tanggal)->format('d');
        }
        $header1 = array_merge($header1, ['Jumlah Hari Kerja', 'H', 'I', 'S', 'A']);
        $data[] = $header1;

        // Baris data user
        $users = User::whereHas('absens')->get();

        foreach ($users as $user) {
            $row = [$user->username];
            $statusCount = ['H' => 0, 'I' => 0, 'C' => 0, 'S' => 0, 'A' => 0];

            foreach ($this->tanggalList as $tanggal) {
                $status = Absen::where('id_user', $user->id)
                    ->whereHas('sesi', function ($q) use ($tanggal) {
                        $q->where('tanggal', $tanggal);
                    })
                    ->value('status');

                $symbol = strtoupper(substr($status, 0, 1)) ?? '';
                $row[] = $symbol;

                if (in_array($symbol, ['H', 'I', 'C', 'S', 'A'])) {
                    $statusCount[$symbol]++;
                }
            }

            $totalHari = array_sum($statusCount);
            $row[] = $totalHari;
            $row[] = $statusCount['H'];
            $row[] = $statusCount['I'];
            $row[] = $statusCount['S'];
            $row[] = $statusCount['A'];

            $data[] = $row;
        }

        return $data;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Bold + border untuk semua data
                $highestRow = $sheet->getHighestRow();
                $highestCol = $sheet->getHighestColumn();
                $range = "A2:{$highestCol}{$highestRow}";

                $sheet->getStyle($range)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center',
                    ],
                    'font' => [
                        'size' => 10,
                    ]
                ]);

                // Warna background untuk kolom Keterangan (baris 2)
                $sheet->getStyle('AF2')->getFill()->setFillType('solid')->getStartColor()->setRGB('00FF00'); // H Hijau
                $sheet->getStyle('AG2')->getFill()->setFillType('solid')->getStartColor()->setRGB('FFFF00'); // I Kuning
                $sheet->getStyle('AH2')->getFill()->setFillType('solid')->getStartColor()->setRGB('FF9900'); // S Oranye
                $sheet->getStyle('AI2')->getFill()->setFillType('solid')->getStartColor()->setRGB('FF0000'); // A Merah
            }
        ];
    }
}
