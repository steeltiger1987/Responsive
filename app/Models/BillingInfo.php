<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillingInfo extends Model
{
    protected $fillable = [
        'billing_name',
        'company_name',
        'business_id',
        'tax_number',
        'address',
        'city',
        'country',
        'email_invoice',
        'bank_account',
    ];

    protected function user()
    {
        $this->belongsTo(User::class);
    }
}
