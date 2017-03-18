<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PickedMover extends Mailable
{
    use Queueable, SerializesModels;

    protected $mover;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $mover)
    {
        $this->mover = $mover;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.customer.picked_mover')->with('mover', $this->mover);
    }
}
