<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Conversation;
use Illuminate\Support\Facades\Cache;

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

    protected $appends = ['isOnline'];

     public function getIsOnlineAttribute()
    {
        return Cache::has('user-online-'. $this->id);
    }

    public function conversations()
    {
        return $this->belongsToMany('App\Conversation', 'user_conversations', 'user_id', 'conversation_id');
    }

    public function conversation(Conversation $conversation)
    {
        return $conversation->messages;
    }
}
