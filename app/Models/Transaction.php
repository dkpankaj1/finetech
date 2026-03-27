<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'reference_no',
        'account_id',
        'customer_id',
        'branch_id',
        'currency_id',
        'transaction_type',
        'source',
        'amount',
        'opening_balance',
        'closing_balance',
        'remarks',
        'transacted_at',
        'created_by',
        'transactionable_type',
        'transactionable_id',
        'counterparty_account_id',
        'counterparty_bank_name',
        'counterparty_account_number',
        'counterparty_ifsc',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'opening_balance' => 'decimal:2',
        'closing_balance' => 'decimal:2',
        'transacted_at' => 'datetime',
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

    public function transactionable()
    {
        return $this->morphTo();
    }

    public function counterpartyAccount()
    {
        return $this->belongsTo(Account::class, 'counterparty_account_id');
    }
}
