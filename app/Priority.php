<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    protected $table = 'priority';

    public function ticket()
    {
    	return $this->belongsTo('App\Ticket', 'priority_id', 'id');
    }
}
