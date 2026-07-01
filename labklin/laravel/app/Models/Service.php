<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = 'services_detail';
    protected $fillable = [
        'id',
        'service_visit_registration_id',
        'service_visit_patient_mr',
        'service_visit_encounter_id',
        'service_servicerequest_id',
        'service_specimen_id',
        'service_observation_id',
        'service_diagnosticreport_id',
        'service_visit_encoded',
        'service_loinc_code',
        'service_loinc_display',
        'service_code',
        'service_name',
        'service_group',
        'service_subgroup',
        'service_result',
        'service_time_result',
        'service_reference',
        'service_price',
        'service_notes',
        'service_quantity',
        'service_handler',
        'updated_at',
    ];
}
