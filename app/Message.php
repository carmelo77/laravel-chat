<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
    	'conversation_id',
    	'user_id',
    	'message',
    	'type'
    ];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
