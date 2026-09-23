<?php

namespace App\Exports\Sheets;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use DateTime;

class MonthlyReportSheet implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected Collection $data;
    protected int $year;
    protected int $month;

    public function __construct(Collection $data, int $year, int $month)
    {
        $this->data = $data;
        $this->year = $year;
        $this->month = $month;
    }

    public function collection(): Collection
    {
        return $this->data;
    }

    public function headings(): array
    {
        $monthName = DateTime::createFromFormat('!m', $this->month)->format('F');

        return [
            ['LAPORAN BULANAN TEGALFOOD'],
            ['Periode: ' . $monthName . ' ' . $this->year],
            [],
            ['No', 'Nama UMKM', 'Total Order', 'Produk Terjual', 'Total Omzet'],
        ];
    }

    public function map($row): array
    {
        return [
            $row['no'],
            $row['nama_umkm'],
            $row['total_order'],
            $row['produk_terjual'],
            $row['total_omzet'],
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            2 => ['font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => '666666']]],
            4 => ['font' => ['bold' => true, 'size' => 11]],
        ];
    }
}
