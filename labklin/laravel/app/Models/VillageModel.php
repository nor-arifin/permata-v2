<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageModel extends Model
{
    use HasFactory;
    protected $table = 'indonesia_villages';
    protected $fillable = [
        'code',
        'district_code',
        'name'
    ];
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
}
