<?php

use Illuminate\Database\Seeder;
use App\Ticket;
use App\User;

class CreateTicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for ($i=0; $i < 100 ; $i++) { 
	        $ticket = new Ticket();
	        $ticket->subject = 'the ticket subject '.$i;
	        $ticket->description = 'the ticket subject '.$i;
	        $ticket->status_id = 1;
	        $ticket->priority_id = 1;
	        $ticket->user_id = User::find(1)->id;

	        $ticket->save();
    	}
        
    }
}
