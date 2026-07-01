<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icd10 extends Model
{
    // use HasFactory;
    protected $table = 'satusehat_icd10';
    protected $fillable = [
        'icd10_code',
        'icd10_id',
        'icd10_en',
    ];
}
