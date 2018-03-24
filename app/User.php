<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Conversation;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function conversations()
    {
        return $this->belongsToMany('App\Conversation', 'user_conversations', 'user_id', 'conversation_id');
    }

    public function conversation(Conversation $conversation)
    {
        return $conversation->messages;
    }
}
