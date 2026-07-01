<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileClinic extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'description',
        'logo',
        'website',
        'pic',
        'acreditation',
        'status',
        'faskes_id',
        'organization_id',
        'client_id',
        'client_secretkey',
        'base_address_longitude',
        'base_address_latitude',
        'base_address_altitude',
        'base_address_use',
        'base_address_line',
        'base_address_city',
        'base_address_country',
        'base_address_postalcode',
        'base_address_extension',
        'base_code_province',
        'base_code_city',
        'base_code_district',
        'base_code_village',
        'base_code_rt',
        'base_code_rw',
        'updated_at',
    ];
}
