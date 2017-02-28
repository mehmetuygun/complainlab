<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';

    public function ticket()
    {
    	return $this->belongsTo('App\Ticket', 'status_id');
    }
}
