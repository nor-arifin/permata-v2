<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_mr',
        'patient_ihs',
        'patient_identifier',
        'patient_nik',
        'patient_kk',
        'patient_name',
        'patient_title', //Added
        'patient_gender',
        'patient_birthplace',
        'patient_birthdate',
        'patient_telecom',
        'patient_religion', //Added
        'patient_email',
        'patient_address_use',
        'patient_address_line',
        'patient_address_city',
        'patient_address_country',
        'patient_address_postalcode',
        'patient_address_extension',
        'patient_code_province',
        'patient_code_city',
        'patient_code_district',
        'patient_code_village',
        'patient_code_rt',
        'patient_code_rw',
        'patient_marital_status',
        'patient_relationship_name',
        'patient_relationship_phone',
        'patient_citizenship_status',
        'patient_deceased',
        'patient_status', //Added
        'patient_bpjs', //Added
        'patient_profession',
        'patient_bloodtype',
        'updated_at',
    ];
}
