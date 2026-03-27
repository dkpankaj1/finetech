<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $fillable = [
        'transaction_id',
        'account_id',
        'customer_id',
        'branch_id',
        'currency_id',
        'reference_no',
        'amount',
        'source',
        'remarks',
        'deposited_at',
        'deposited_by',
    ];

    protected $casts = [
        'amount'      => 'decimal:2',
        'deposited_at' => 'datetime',
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

    public function depositor()
    {
        return $this->belongsTo(User::class, 'deposited_by');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
