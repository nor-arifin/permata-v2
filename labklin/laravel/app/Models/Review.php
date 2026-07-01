<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $table = 'kesmas_reviews';
    protected $fillable = [
        'review_code',
        'review_date',
        'review_personnel',
        'review_accomodation',
        'review_workload',
        'review_equipment',
        'review_method',
        'review_note',
        'review_conclution',
        'review_by',
    ];
}
