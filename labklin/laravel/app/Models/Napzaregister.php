<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Napzaregister extends Model
{
    use HasFactory;
    protected $fillable = [
        'letter_napza_date',
        'letter_napza_number',
        'letter_napza_name',
        'letter_napza_mr',
        'letter_napza_lhu',
        'letter_napza_purpose',
        'letter_napza_conclution',
        'letter_napza_signed',
        'letter_napza_encode',
    ];
}