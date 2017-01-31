<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'ticket';

    public function status()
    {
    	return $this->hasOne('App\Status', 'id', 'status_id');
    }

    public function user()
    {
    	return $tihs->belongsTo('App\User', 'id', 'user_id');
    }

    public function priority()
    {
    	return $this->hasOne('App\Priority', 'id', 'priority_id');
    }
}
