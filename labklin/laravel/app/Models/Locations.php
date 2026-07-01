<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    use HasFactory;
    protected $fillable = [
        'location_code',
        'location_name',
        'location_uuid',
        'location_physical_type',
        'location_status',
        'location_description',
        'location_mode',
        'location_telecom',
        'location_email',
        'location_position_longitude',
        'location_position_latitude',
        'location_position_altitude',
        'location_address_use',
        'location_address_line',
        'location_address_city',
        'location_address_country',
        'location_address_postalcode',
        'location_address_extension',
        'location_code_province',
        'location_code_city',
        'location_code_district',
        'location_code_village',
        'location_code_rt',
        'location_code_rw',
        'location_organization',
    ];
}
