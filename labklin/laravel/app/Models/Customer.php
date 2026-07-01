<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'kesmas_customers';
    protected $fillable = [
        'customer_code',
        'customer_name',
        'customer_type',
        'customer_address',
        'customer_address_detail',
        'customer_phone',
        'customer_email',
        'customer_pic',
        'customer_pic_phone',
        'customer_status',
        'customer_username',
        'customer_password',
        'customer_registered',
        'customer_encode',
    ];
}
