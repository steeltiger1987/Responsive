<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * Get all of the owning commentable models.
     */
    public function imagable()
    {
        return $this->morphTo();
    }
}
