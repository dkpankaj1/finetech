<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $fillable = [
        'language',
        'timezone',
        'date_format',
        'time_format',
        'currency_id',
        'decimal_separator',
        'thousands_separator',
        'decimal_places',
        'session_timeout',
        'max_login_attempts',
        'enable_two_factor',
        'per_page',
        'enable_maintenance',
        'maintenance_message'
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
}
