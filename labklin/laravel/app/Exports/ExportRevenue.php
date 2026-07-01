<?php

namespace App\Exports;

use App\Models\Visit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportRevenue implements FromCollection, WithHeadings
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
        return Visit::selectRaw('DATE(visit_date) as date, SUM(visit_payment_charge) as totalcharge, SUM(visit_payment_amount) as totalrevenue, SUM(visit_payment_discount) as totaldiscount')
                ->whereYear('visit_date', $this->year)
                ->whereMonth('visit_date', $this->month)
                ->groupBy('date')
                ->orderBy('date')
                ->get([
                    'visit_date',
                    'totalcharge',
                    'totaldiscount',
                    'totalrevenue'
                ]);
    }

    public function headings(): array
    {
        return [
            'Date',
            'Total Charge',
            'Total Discount',
            'Total Revenue',
        ];
    }
}
