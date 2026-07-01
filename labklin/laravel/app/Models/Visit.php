<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_registration_id',
        'visit_patient_name',
        'visit_patient_mr',
        'visit_patient_ihs',
        'visit_patient_telecom',
        'visit_patient_dept',
        'visit_method',
        'visit_doctor_id',
        'visit_doctor_name',
        'visit_location_id',
        'visit_location_name',
        'visit_status_timeline',
        'visit_registered_by',
        'visit_time_sampling',
        'visit_sampling_by',
        'visit_time_hematology',
        'visit_time_clinicalchemistry',
        'visit_time_immunology',
        'visit_time_microbiology',
        'visit_time_virology',
        'visit_time_other',
        'visit_time_validation',
        'visit_validation_impression',
        'visit_validation_by',
        'visit_payment_charge',
        'visit_payment_discount',
        'visit_payment_voucher',
        'visit_payment_method',
        'visit_payment_amount',
        'visit_payment_remaining',
        'visit_payment_time',
        'visit_payment_officer',
        'visit_icd10_code',
        'visit_icd10_display',
        'visit_category',
        'visit_clinical_status',
        'visit_date_arrived',
        'visit_date_progress',
        'visit_date_finished',
        'visit_condition_onset',
        'visit_condition_recorded',
        'visit_encounter_id',
        'visit_encoded',
        'visit_date',
        'visit_patient_status',
        'visit_patient_account',
    ];

}