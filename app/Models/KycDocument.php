<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KycDocument extends Model
{
    protected $fillable = [
        'customer_id',
        'document_type',
        'document_number',
        'front_image',
        'back_image',
        'expiry_date',
        'status',
        'reviewed_by',
        'reviewed_at',
        'remark',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
