<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\BankReceipt;

class BankReceiptSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    protected $receipt;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(BankReceipt $receipt)
    {
        $this->receipt = $receipt;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data['receipt'] = $this->receipt;
        return $this->bcc(env('MAIL_FROM_ADDRESS'))
                    ->view('mail.bank_receipt_submitted', $data);

    }
}
