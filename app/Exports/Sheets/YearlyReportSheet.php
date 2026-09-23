<?php

namespace App\Exports\Sheets;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class YearlyReportSheet implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected Collection $data;
    protected int $year;

    public function __construct(Collection $data, int $year)
    {
        $this->data = $data;
        $this->year = $year;
    }

    public function collection(): Collection
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            ['LAPORAN TAHUNAN TEGALFOOD'],
            ['Periode: Tahun ' . $this->year],
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
