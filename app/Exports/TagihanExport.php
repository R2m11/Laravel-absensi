<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet;

class TagihanExport implements FromView, WithHeadings
{
    protected $kehadiran;
    protected $filteredTanggalAbsensi;
    protected $groupUser;
    protected $kasbon;

    public function __construct($kehadiran, $filteredTanggalAbsensi,$groupUser,$kasbon)
    {
        $this->kehadiran = $kehadiran;
        $this->filteredTanggalAbsensi = $filteredTanggalAbsensi;
        $this->groupUser = $groupUser;
        $this->kasbon = $kasbon;

    }

    public function view(): View
    {
        return view('tagihan.tagihan_excel', [
            'kehadiran' => $this->kehadiran,
            'filteredTanggalAbsensi' => $this->filteredTanggalAbsensi,
            'groupUser' => $this->groupUser,
            'kasbon' => $this->kasbon,
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
        'Nama',
        'Kode Karyawan',
        'Level Gaji',
        'Total Masuk',
        'Proyek Bagian',
        'Total Upah Lemburan',
        'Total Gaji Harian',
        'Kasbon',
        'Total Upah',
        'Bagian',
        'Total Masuk',
        'Nilai Tagihan',
        'Total Tagihan',
        'Member Bagian',
        ];
    }
}
