<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ShiftTotalExport implements FromCollection, WithHeadings, WithMapping
{
    protected $shiftData;
    protected $month;
    protected $year;

    public function __construct($shiftData, $month, $year)
    {
        $this->shiftData = $shiftData;
        $this->month = $month;
        $this->year = $year;
    }

    public function collection()
    {
        return $this->shiftData; // Use the data passed from the controller
    }

    public function headings(): array
    {
        $headings = ['Shift'];
        
        // Add days dynamically based on the month and year
        for ($i = 1; $i <= cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year); $i++) {
            $headings[] = str_pad($i, 2, '0', STR_PAD_LEFT);
        }

        $headings[] = 'Total';

        return $headings;
    }

    public function map($report): array
    {
        $data = [$report->shift_category];

        // Add the daily shift count for each day of the month
        for ($i = 1; $i <= cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year); $i++) {
            $data[] = $report->{$i} ?? 0;
        }

        // Add total for the row
        $data[] = collect(range(1, cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year)))->sum(fn($day) => $report->{$day} ?? 0);

        return $data;
    }
}
