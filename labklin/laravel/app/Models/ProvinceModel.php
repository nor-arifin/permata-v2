<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvinceModel extends Model
{
    use HasFactory;
    protected $table = 'indonesia_provinces';
    protected $fillable = [
        'code',
        'name'
    ];

    public function kota()
    {
        return $this->hasMany(CityModel::class);
    }
}

