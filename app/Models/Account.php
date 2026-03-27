<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'account_number',
        'customer_id',
        'account_type_id',
        'branch_id',
        'currency_id',
        'opening_balance',
        'current_balance',
        'status',
        'status_reason',
        'last_transaction_at',
        'opened_at',
        'closed_at',
        'opened_by',
    ];

    protected $casts = [
        'opening_balance'     => 'decimal:2',
        'current_balance'     => 'decimal:2',
        'last_transaction_at' => 'datetime',
        'opened_at'           => 'date',
        'closed_at'           => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function accountType()
    {
        return $this->belongsTo(AccountType::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function openedBy()
    {
        return $this->belongsTo(User::class, 'opened_by');
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function fixedDeposits()
    {
        return $this->hasMany(FixedDeposit::class);
    }
}
