<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixedDeposit extends Model
{
    protected $fillable = [
        'fd_number',
        'account_id',
        'customer_id',
        'branch_id',
        'currency_id',
        'principal_amount',
        'interest_rate',
        'tenure_months',
        'maturity_amount',
        'status',
        'opened_at',
        'maturity_date',
        'closed_at',
        'remarks',
        'created_by',
    ];

    protected $casts = [
        'principal_amount' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'maturity_amount' => 'decimal:2',
        'opened_at' => 'date',
        'maturity_date' => 'date',
        'closed_at' => 'date',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
