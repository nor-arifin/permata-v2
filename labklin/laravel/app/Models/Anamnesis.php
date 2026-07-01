<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anamnesis extends Model
{
    use HasFactory;
    protected $fillable = [
        'visit_encounter_id',
        'visit_registration_id',
        'condition_clinicalstatus',
        'condition_category',
        'condition_code',
        'condition_display',
        'condition_subject',
        'condition_onset',
        'condition_recorded',
        'condition_note',
        'observation_heartrate',
        'observation_respiratory',
        'observation_systolic',
        'observation_diastolic',
        'observation_temperature',
        'updated_at',
    ];

}
