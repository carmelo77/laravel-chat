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
}
