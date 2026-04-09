<?php

namespace App\Mail\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomerEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Customer Email',
        );
    }

    public function build()
    {
        return $this->subject('The code verify')
                    ->view('front-end.auth.email-verify')
                    ->with([
                        'data' => $this->data,
                    ]);
    }

    public function attachments(): array
    {
        return [];
    }
}
