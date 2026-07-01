<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistrictModel extends Model
{
    use HasFactory;
    protected $table = 'indonesia_districts';
    protected $fillable = [
        'code',
        'city_code',
        'name'
    ];
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
}
