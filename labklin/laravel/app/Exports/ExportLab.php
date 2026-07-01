<?php

namespace App\Exports;

use App\Models\Service;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportLab implements FromCollection, WithHeadings
{
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function collection()
    {
        return Service::selectRaw(' service_name as test, SUM(service_quantity) as quantity')
                ->whereYear('created_at', $this->year)
                ->whereMonth('created_at', $this->month)
                ->whereNotNull('service_price')
                ->whereNotNull('service_time_result')
                ->groupBy('test')
                ->orderBy('quantity')
                ->get([
                    'test',
                    'quantity',
                ]);
    }

    public function headings(): array
    {
        return [
            'Test Name',
            'Total Order',
        ];
    }
}
