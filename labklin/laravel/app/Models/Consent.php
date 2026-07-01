<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consent extends Model
{
    use HasFactory;
    protected $fillable = [
        'consent_uuid',
        'consent_patient_id',
        'consent_action',
        'consent_agent',
        'consent_patient_name',
        'consent_patient_mr',
    ];
}
