<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kesmas extends Model
{
    use HasFactory;
    protected $table = 'kesmas_orders';
    protected $fillable = [
        'order_code',
        'order_date',
        'order_customer',
        'order_type',
        'order_status',
        'order_review',
        'order_review_user',
        'order_collect',
        'order_collect_user',
        'order_receive',
        'order_receive_user',
        'order_process',
        'order_process_user',
        'order_verify',
        'order_verify_user',
        'order_validate',
        'order_validate_user',
        'order sign',
        'order_sign_user',
        'order_finish',
        'order_finish_user',
        'order_total',
        'order_user',
        'order_payment_date',
        'order_payment_method',
        'order_payment_amount',
        'order_payment_user',
        'order_encode',
        'created_at',
        'updated_at',
    ];
}
