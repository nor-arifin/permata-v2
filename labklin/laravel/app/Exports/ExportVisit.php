<?php

namespace App\Exports;

use App\Models\Visit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportVisit implements FromCollection, WithHeadings
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
        return Visit::whereYear('visit_date', $this->year)
                ->whereMonth('visit_date', $this->month)
                ->get([
                    'visit_date',
                    'visit_registration_id',
                    'visit_patient_name',
                    'visit_patient_mr',
                    'visit_patient_dept',
                    'visit_doctor_name',
                    'visit_status_timeline',
                    'visit_registered_by',
                    'visit_payment_charge',
                    'visit_payment_discount',
                    'visit_payment_method',
                    'visit_payment_amount',
                    'visit_payment_time',
                    'visit_payment_officer',
                    'visit_icd10_display',
                    'visit_patient_status',
                    'visit_patient_account',
                ]);
    }

    public function headings(): array
    {
        return [
            'Date',
            'Registration No.',
            'Patient Name',
            'Patient MR',
            'Department',
            'Doctor',
            'Patient Timeline',
            'Registered By',
            'Charge',
            'Discount',
            'Payment Method',
            'Payment Amount',
            'Payment Time',
            'Payment Officer',
            'Diagnosis',
            'Payment Assurance',
            'Assurance Account',
        ];
    }
}
