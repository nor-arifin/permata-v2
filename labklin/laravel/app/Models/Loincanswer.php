<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loincanswer extends Model
{
    use HasFactory;

    protected $table = 'loinc_answers';
    protected $fillable = [
        'id',
        'loinc_code',
        'loinc_name',
        'answer_list_id',
        'answer_list_name',
        'answer_list_type',
        'answer_id',
        'answer_sequence',
        'answer_display_text',
        'answer_system',
    ];
}