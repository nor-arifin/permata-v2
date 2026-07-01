<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    protected $table = 'kesmas_parameters';
    protected $fillable = [
        'parameter_code',
        'parameter_name',
        'parameter_method',
        'parameter_unit',
        'parameter_category',
        'parameter_group',
        'parameter_subgroup',
        'parameter_specimen',
        'parameter_container',
        'parameter_parent',
        'parameter_reference_type',
        'parameter_reference_value',
        'parameter_price',
        'parameter_acreditation',
        'parameter_time',
        'parameter_status',
        'parameter_description',
        'parameter_encode',
    ];
}