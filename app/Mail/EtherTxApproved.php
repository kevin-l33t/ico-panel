<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\TransactionLog;

class EtherTxApproved extends Mailable
{
    use Queueable, SerializesModels;

    protected $txLog;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(TransactionLog $txLog)
    {
        $this->txLog = $txLog;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data['log'] = $this->txLog;
        return $this->bcc(env('MAIL_FROM_ADDRESS'))
                    ->view('mail.eth_tx_approved', $data);
    }
}
