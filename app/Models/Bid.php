<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{

    protected $fillable = [
        'bid',
        'car_id',
        'user_id',
        'order_id',
        'ride_along',
        'ride_along_client',
        'movers',
        'movers_count',
        'spolumoving'
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function mover()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function job()
    {
        return $this->hasOne(Job::class);
    }
}
