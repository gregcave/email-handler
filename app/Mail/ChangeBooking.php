<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChangeBooking extends Mailable
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
					->subject('Modify Booking')
					->with([
                        'title' => '<h1 style="font-size: 26px; font-weight: 600; margin: 0;">Request to Modify your Booking</h1>',
						'body' => '<p style="margin: 0;">Your Booking: <br><strong>Flight ' . $this->email['flight'] . ' to ' . $this->email['destination'] . ' @ ' . $this->email['time'] . '</strong><br>A request to modify your booking has been made, a member of staff will be in contact within two business days.</p>',
						'footer' => '<p style="margin: 0;">You\'ve received this message because you have recently emailed us to modify a holiday booking.</p>'
                    ]);
    }
}
