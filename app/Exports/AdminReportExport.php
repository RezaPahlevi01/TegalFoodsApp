<?php

namespace App\Exports;

use App\Exports\Sheets\MonthlyReportSheet;
use App\Exports\Sheets\YearlyReportSheet;
use App\Exports\Sheets\MenuSheet;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AdminReportExport implements WithMultipleSheets, ShouldAutoSize
{
    protected array $exports;
    protected int $year;
    protected ?int $month;
    protected ?array $monthlyData;
    protected ?array $yearlyData;
    protected ?array $menuData;

    public function __construct(array $exports, int $year, ?int $month, ?array $monthlyData, ?array $yearlyData, ?array $menuData)
    {
        $this->exports = $exports;
        $this->year = $year;
        $this->month = $month;
        $this->monthlyData = $monthlyData;
        $this->yearlyData = $yearlyData;
        $this->menuData = $menuData;
    }

    public function sheets(): array
    {
        $sheets = [];

        if (in_array('monthly', $this->exports) && $this->monthlyData !== null) {
            $sheets[] = new MonthlyReportSheet(
                collect($this->monthlyData),
                $this->year,
                $this->month
            );
        }

        if (in_array('yearly', $this->exports) && $this->yearlyData !== null) {
            $sheets[] = new YearlyReportSheet(
                collect($this->yearlyData),
                $this->year
            );
        }

        if (in_array('menus', $this->exports) && $this->menuData !== null) {
            $sheets[] = new MenuSheet(
                collect($this->menuData)
            );
        }

        return $sheets;
    }
}
