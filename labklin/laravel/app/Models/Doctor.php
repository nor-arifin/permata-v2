<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $fillable = [
        'doctor_name',
        'doctor_email',
        'doctor_phone',
        'doctor_sip',
        'doctor_speciality',
        'doctor_photo',
        'doctor_id',
        'doctor_gender',
        'doctor_nik',
        'doctor_birthdate',
        'updated_at',
    ];
}
