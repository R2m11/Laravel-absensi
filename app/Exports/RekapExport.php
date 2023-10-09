<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet;

class RekapExport implements FromView, WithHeadings
{
    protected $kehadiran;
    protected $filteredTanggalAbsensi;
    protected $groupUser;
    // protected $absensi;
    // protected $status;

    public function __construct($kehadiran, $filteredTanggalAbsensi,$groupUser)
    {
        $this->kehadiran = $kehadiran;
        $this->filteredTanggalAbsensi = $filteredTanggalAbsensi;
        $this->groupUser = $groupUser;
        // $this->absensi = $absensi;
        // $this->status = $status;
    }

    public function view(): View
    {
        return view('rekap.rekap_excel', [
            'kehadiran' => $this->kehadiran,
            'filteredTanggalAbsensi' => $this->filteredTanggalAbsensi,
            'groupUser' => $this->groupUser,
            // 'absensi' => $this->absensi,
            // 'status' => $this->status
        ]);
    }
    public function styles(Worksheet $sheet)
    {
        return [
            // Styling untuk header kolom
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '333333'],
                ],
            ],

            // Styling untuk sel data
            'A' => [
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'FFFF00'],
                ],
            ],
        ];
    }

    public function headings(): array
    {
        return [
        'No.',
        'Nama',
        'Kode Karyawan',
        'status',
        'bagian'
        ];
    }
}
