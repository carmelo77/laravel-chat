<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
	protected $fillable = [
    	'name'
    ];

    public function messages()
    {
    	return $this->hasMany('App\Message');
    }

    public function users()
    {
    	return $this->belongsToMany('App\User', 'user_conversations', 'conversation_id', 'user_id');
    }    
}
