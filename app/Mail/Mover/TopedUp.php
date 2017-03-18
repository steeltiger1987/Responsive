<?php

namespace App\Mail\Mover;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use PDF;

class TopedUp extends Mailable
{
    use Queueable, SerializesModels;


    private $user;
    private $payment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Payment $payment)
    {
        $this->user = $user;
        $this->payment = $payment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            'company_name' => $this->user->billingInfo()->first()->company_name,
            'address' => $this->user->billingInfo()->first()->address,
            'city' => $this->user->billingInfo()->first()->city,
            'country' => $this->user->billingInfo()->first()->country,
            'business_id' => $this->user->billingInfo()->first()->business_id,
            'tax_id' => $this->user->billingInfo()->first()->tax_number,
            'variable' => $this->user->variable,
            'date_top_up' => $this->payment->created_at,
            'amount' => $this->payment->amount,
            'currency' => $this->payment->currency,
            'id' => $this->payment->id
        ];

        $pdf = PDF::loadView('pdf.invoice', $data);
        $pdf->save(public_path().'/invoices/invoice-'.$this->payment->created_at.'-'.$this->payment->id.'.pdf');

        return $this->view('emails.mover.toped_up')
            ->attachData($pdf->output(), 'invoice.pdf', [
                'mime'  =>  'application/pdf',
            ]);
    }
}
