<?php

namespace App\Exports\Sheets;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MenuSheet implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected Collection $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection(): Collection
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            ['MENU MAKANAN UMKM'],
            [],
            ['No', 'Nama UMKM', 'Menu', 'Harga'],
        ];
    }

    public function map($row): array
    {
        return [
            $row['no'],
            $row['nama_umkm'],
            $row['menu'],
            $row['harga'],
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            3 => ['font' => ['bold' => true, 'size' => 11]],
        ];
    }
}
