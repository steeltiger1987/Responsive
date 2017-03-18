<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
        'size',
        'length',
        'width',
        'height',
        'amount',
        'type',
        'description',
        'assemb_dissasemb_need',
        'fit_to_elevator',
        'packaking_need'
    ];

    /**
     * Get all of the post's comments.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imagable');
    }

}
