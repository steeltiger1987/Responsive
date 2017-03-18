<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{

    protected $fillable = [
        'model',
        'type',
        'loading_capacity',
        'year',
        'photo',
        'manufacturer'
    ];

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imagable');
    }

    protected function getFullCarNameAttribute()
    {
        return $this->manufacturer . ' ' . $this->model . ' ' . $this->year;
    }

    public function getCarImagePath()
    {
        if (!$this->images()->first()) {
            return false;
        }

        return '/uploads/car/' . $this->images()->where('custom', 'cars')->first()->path;
    }

    public function getDriverImagePath()
    {
        if (!$this->images()->first()) {
            return false;
        }
        return '/uploads/driver/' . $this->images()->where('custom', 'driver')->first()->path;
    }

}
