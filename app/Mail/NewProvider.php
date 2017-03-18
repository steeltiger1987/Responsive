<?php

namespace App\Mail;

use App\Models\Bid;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewProvider extends Mailable
{
    use Queueable, SerializesModels;


    protected $mover;
    protected $bid;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $mover, Bid $bid)
    {
        $this->mover = $mover;
        $this->bid = $bid;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.customer.new_provider')->with(['mover' => $this->mover, 'bid' => $this->bid]);
    }
}
