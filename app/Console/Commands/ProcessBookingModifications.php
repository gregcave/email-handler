<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Webklex\IMAP\Client;
use App\Mail\ChangeBooking;

class ProcessBookingModifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change Booking.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
		$oClient = new Client([
			'host'          => 'somehost.com',
			'port'          => 993,
			'encryption'    => 'ssl',
			'validate_cert' => true,
			'username'      => 'username',
			'password'      => 'password',
			'protocol'      => 'imap'
		]);
		
		$oClient->connect();
		$aFolder = $oClient->getFolders();
		
		foreach($aFolder as $oFolder)
		{
			$aMessage = $oFolder->query()->unseen()->text("I would like to change my booking dates")->markAsRead()->get();
			
			foreach($aMessage as $oMessage)
			{
				$address = json_decode(json_encode($oMessage->getSender()), true);
				
				$email = array(
					'destination' => 'Madrid - Spain',
					'flight' => 'SP3676',
					'time' => '17:00 GMT',
				);
				
				Mail::to($address[0]['mail'])->send(new ChangeBooking($email));
			}
		}	
    }
}
