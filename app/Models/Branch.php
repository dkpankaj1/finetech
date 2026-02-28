<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use SoftDeletes;

    protected $fillable = [
        // Identity
        'name',
        'code',
        'ifsc_code',
        'micr_code',
        'swift_code',

        // Location
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'latitude',
        'longitude',

        // Contact
        'phone_number',
        'alternate_phone',
        'email',
        'fax',

        // Operations
        'opening_time',
        'closing_time',
        'manager_name',
        'manager_email',
        'manager_phone',

        // Status
        'is_active',
        'is_main_branch',
        'remarks',
    ];

    protected $casts = [
        'is_active'      => 'boolean',
        'is_main_branch' => 'boolean',
        'latitude'       => 'float',
        'longitude'      => 'float',
        'opening_time'   => 'datetime:H:i',
        'closing_time'   => 'datetime:H:i',
    ];
}
