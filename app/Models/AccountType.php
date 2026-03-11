<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    protected $fillable = [
        'name',
        'code',
        'interest_rate',
        'minimum_balance',
        'maximum_balance',
        'daily_deposit_limit',
        'daily_withdrawal_limit',
        'monthly_free_transactions',
        'requires_kyc',
        'is_active',
    ];
}
