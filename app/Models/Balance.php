<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{

    protected $fillable = ['amount', 'user_id'];

    public function addFunds($amount)
    {
        $this->amount += $amount;
        return $this->save();
    }

    public function removeFunds($amount)
    {
        $this->amount -= $amount;

        return $this->save();
    }

    public function getBalance()
    {
        return $this->amount;
    }
}
