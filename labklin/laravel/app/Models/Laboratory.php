<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laboratory extends Model
{
    use HasFactory;
    protected $table = 'laboratories';
    protected $fillable = [
        'id',
        'test_loinc_code',
        'test_loinc_display',
        'test_code',
        'test_name',
        'test_unit',
        'test_method',
        'test_specimen',
        'test_specimen_vol',
        'test_container',
        'test_resulttype',
        'test_normal_general',
        'test_min_general',
        'test_max_general',
        'test_normal_male',
        'test_min_male',
        'test_max_male',
        'test_normal_female',
        'test_min_female',
        'test_max_female',
        'test_normal_baby',
        'test_min_baby',
        'test_max_baby',
        'test_normal_child',
        'test_min_child',
        'test_max_child',
        'test_group',
        'test_subgroup',
        'test_category',
        'test_partof',
        'test_active',
        'test_price',
        'test_quantity',
        'test_description',
    ];

}