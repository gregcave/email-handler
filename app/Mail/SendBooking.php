<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendBooking extends Mailable
{
    use Queueable, SerializesModels;

	protected $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {		
        return $this->view('email')
					->subject('Holiday Details')
					->with([
                        'title' => '<h1 style="font-size: 26px; font-weight: 600; margin: 0;">Your Holiday Details</h1>',
						'body' => '<p style="margin: 0;">Your Holiday Details are as Follows: <br><strong>Flight ' . $this->email['flight'] . ' to ' . $this->email['destination'] . ' @ ' . $this->email['time'] . '</strong>.</p>',
						'footer' => '<p style="margin: 0;">You\'ve received this message because you have recently emailed us to view your holiday booking details.</p>'
                    ]);
    }
}
