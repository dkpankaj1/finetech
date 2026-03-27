<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $fillable = [
        'account_id',
        'customer_id',
        'branch_id',
        'currency_id',
        'reference_no',
        'amount',
        'source',
        'remarks',
        'withdrawn_at',
        'withdrawn_by',
    ];

    protected $casts = [
        'amount'       => 'decimal:2',
        'withdrawn_at' => 'datetime',
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

    public function withdrawer()
    {
        return $this->belongsTo(User::class, 'withdrawn_by');
    }
}
