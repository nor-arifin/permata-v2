<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityModel extends Model
{
    use HasFactory;
    protected $table = 'indonesia_cities';
    protected $fillable = [
        'code',
        'province_code',
        'name'
    ];

    public function provinsi()
    {
        return $this->belongsTo(ProvinceModel::class);
    }
    public function kota()
    {
        return $this->hasMany(DistrictModel::class);
    }
}
