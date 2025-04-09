<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class user_mail extends Mailable
{
    use Queueable, SerializesModels;

    public $msg;
    public $subject;

    public function __construct($msg, $subject)
    {
        $this->msg = $msg;
        $this->subject = $subject;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    public function build()
    {
        return $this->subject($this->subject)
                    ->view('mail_product')  
                    ->with([
                        'msg' => $this->msg,
                        'subject' => $this->subject
                    ]);
    }

     /**
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}