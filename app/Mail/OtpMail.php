<?php 
namespace App\Mail;

use Illuminate\Mail\Mailable;

class OtpMail extends Mailable
{
    public $otp;

    // Constructor accepts OTP as a parameter
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    // Build the email
    public function build()
    {
        return $this->subject('Your OTP Code')  
                    ->view('welcome')
                    ->with([
                        'otp' => $this->otp,  
                         ]);
    }
}
