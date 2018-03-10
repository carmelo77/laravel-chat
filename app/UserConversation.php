<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserConversation extends Model
{
    protected $fillable = [
    	'conversation_id',
    	'user_id'
    ];

    public function conversation()
    {
    	return $this->belongsTo('App\Conversation');
    }
}
