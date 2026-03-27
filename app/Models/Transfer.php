<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = [
        'reference_no',
        'source_account_id',
        'source_customer_id',
        'source_branch_id',
        'currency_id',
        'transfer_type',
        'destination_account_id',
        'destination_bank_name',
        'destination_account_number',
        'destination_ifsc',
        'beneficiary_name',
        'amount',
        'remarks',
        'transferred_at',
        'transferred_by',
        'source_transaction_id',
        'destination_transaction_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transferred_at' => 'datetime',
    ];

    public function sourceAccount()
    {
        return $this->belongsTo(Account::class, 'source_account_id');
    }

    public function destinationAccount()
    {
        return $this->belongsTo(Account::class, 'destination_account_id');
    }

    public function sourceCustomer()
    {
        return $this->belongsTo(Customer::class, 'source_customer_id');
    }

    public function sourceBranch()
    {
        return $this->belongsTo(Branch::class, 'source_branch_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function transferBy()
    {
        return $this->belongsTo(User::class, 'transferred_by');
    }

    public function sourceTransaction()
    {
        return $this->belongsTo(Transaction::class, 'source_transaction_id');
    }

    public function destinationTransaction()
    {
        return $this->belongsTo(Transaction::class, 'destination_transaction_id');
    }
}
