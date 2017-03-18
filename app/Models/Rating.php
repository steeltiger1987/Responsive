<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{

    protected $fillable = ['rating', 'user_id', 'job_id', 'comment'];

    public function setRating($rating)
    {
        $this->rating = $rating;
        return $this;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    public function setUser($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function setJob($job_id)
    {
        $this->job_id = $job_id;

        return $this;
    }
}
