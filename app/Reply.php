<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $table = 'reply';

    public function ticket()
    {
    	return $this->belongsTo('App\Ticket');
    }
}
