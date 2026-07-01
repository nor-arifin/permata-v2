<?php

namespace App\Exports;

use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportLabDetail implements FromCollection, WithHeadings
{
    protected $month;
    protected $year;
    protected $coder;

    public function __construct($month, $year, $coder)
    {
        $this->month = $month;
        $this->year = $year;
        $this->coder = $coder;
    }

    public function collection()
    {
        return DB::table('services_detail')
        ->select(
            'services_detail.created_at as date',
            'visits.visit_registration_id as noreg',
            'visits.visit_patient_name as name',
            'visits.visit_patient_mr as mr',
            'service_name as test',
            'service_result as result',
            'service_reference as reference',
            'laboratories.test_unit as unit')
        ->join('visits', 'services_detail.service_visit_registration_id', '=', 'visits.visit_registration_id')
        ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
        ->where('services_detail.service_code', $this->coder)
        ->whereYear('services_detail.created_at', $this->year)
        ->whereMonth('services_detail.created_at', $this->month)
        ->whereNotNull('service_price')
        ->whereNotNull('service_time_result')
        ->orderBy('noreg')
        ->get([
            'date',
            'noreg',
            'name',
            'mr',
            'test',
            'result',
            'reference',
            'unit',
        ]);
    }

    public function headings(): array
    {
        return [
            'Date',
            'No Reg',
            'Name',
            'MR',
            'Test',
            'Result',
            'Reference',
            'Unit',
        ];
    }
}
