<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organizations extends Model
{
    use HasFactory;
    protected $fillable = [
        'organization_uuid',
        'organization_code',
        'organization_name',
        'organization_type',
        'organization_telecom',
        'organization_email',
        'organization_status',
        'organization_address_use',
        'organization_address_line',
        'organization_address_city',
        'organization_address_country',
        'organization_address_postalcode',
        'organization_code_province',
        'organization_code_city',
        'organization_code_district',
        'organization_code_village',
    ];
}
