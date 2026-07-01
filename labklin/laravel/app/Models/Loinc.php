<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loinc extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'loinc_code',
        'loinc_display',
        'loinc_component',
        'loinc_property',
        'loinc_timing',
        'loinc_system',
        'loinc_scale',
        'loinc_method',
        'loinc_unitofmeasure',
        'loinc_codesystem',
    ];
}