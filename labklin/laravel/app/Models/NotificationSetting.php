<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    protected $fillable = [
        'api_token',
        'fallback_number',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
