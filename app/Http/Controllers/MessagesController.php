<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Conversation;
use App\UserConversation;
use App\Message;

use Auth;

class MessagesController extends Controller
{
    public function fetch(Request $request)
    {
    	$userLogged = Auth::user();
    	$userTo = User::find($request->user);

    	if (!$request->conversation) {
    		$userLogged = Auth::user();
	    	$userTo = User::find($request->user);

	    	$conversation1 = UserConversation::where('user_id', $userLogged->id)->get();
	    	$conversations2 = UserConversation::where('user_id', $userTo->id)->get();

	    	$conversation = null;

	    	foreach ($conversations2 as $conversation2) {
	    		$conversation = $conversation1->where('conversation_id', $conversation2->conversation_id)->first();

	    		if ($conversation) {
	    			$conversation = $conversation->conversation;
	    			break;
	    		}
	    	}
    	}else{
    		$conversation = Conversation::find($request->conversation);
    	}

    	if (!$conversation) {
    		return [];
    	}

    	$messages = [];

    	foreach ($conversation->messages as $index => $message) {
    		$messages[$index] = $message;

    		$messages[$index]->user = $message->user;
    	}

    	return response()->json($messages);
    }

    public function sentMessage(Request $request)
    {
    	$request->validate([
    		'user' => 'required',
    		'message' => 'required|min:3',
    	]);

    	$userLogged = Auth::user();
    	$userTo = User::find($request->user);

    	$conversation1 = UserConversation::where('user_id', $userLogged->id)->get();
    	$conversations2 = UserConversation::where('user_id', $userTo->id)->get();

    	$conversation = null;

    	foreach ($conversations2 as $conversation2) {
    		$conversation = $conversation1->where('conversation_id', $conversation2->conversation_id)
    			->first()->conversation;

    		if ($conversation) {
    			break;
    		}
    	}

    	if (!$conversation) {
    		$conversation = Conversation::create();

    		//user 1
    		UserConversation::create([
    			'conversation_id' => $conversation->id,
    			'user_id' => $userLogged->id,
    		]);

    		//user 2
    		UserConversation::create([
    			'conversation_id' => $conversation->id,
    			'user_id' => $userTo->id,
    		]);

    		$conversation1 = UserConversation::where('user_id', $userLogged->id)->get();
    		$conversations2 = UserConversation::where('user_id', $userTo->id)->get();

    		foreach ($conversations2 as $conversation2) {
	    		$conversation = $conversation1->where('conversation_id', $conversation2->conversation_id)
	    			->first()->conversation;

	    		if ($conversation) {
	    			break;
	    		}
	    	}
    	}

    	$message = Message::create([
    		'conversation_id' => $conversation->id,
    		'user_id' => $userLogged->id,
    		'message' => $request->message,
    	]);

    	return response()->json($conversation);
    }
}
