<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = ['user_id', 'order_id', 'bid_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bid()
    {
        return $this->belongsTo(Bid::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getCar()
    {
        return $this->bid()->first()->car()->first();
    }

    public function getUser()
    {
        return $this->user()->first();
    }

    public function isRated()
    {

        if (count($this->user()->first()->ratings()->where(['user_id' => $this->user_id, 'job_id' => $this->id])->get()) > 0) {
            return true;
        }

        return false;
    }


}
