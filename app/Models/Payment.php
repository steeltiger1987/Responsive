<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'type', 'amount', 'currency', 'reference', 'result', 'tid', 'oid'
    ];

    public function getUserId()
    {
        $spilttedString = explode('_', $this->reference);
        return $spilttedString[1];
    }
}
