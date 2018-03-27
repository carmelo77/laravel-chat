<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Conversation;
use App\UserConversation;
use App\Message;
use LRedis;

use Auth;
use Storage;

class MessagesController extends Controller
{
    public function fetch(Request $request)
    {
    	$userLogged = Auth::user();
    	$userTo = User::find($request->user);

    	$conversation = $this->getConversation($request->conversation,  $userTo);

    	if (!$conversation) {
    		return [];
    	}

    	$messages = [];

    	foreach ($conversation->messages as $index => $message) {
    		$messages[$index] = $message;

            $messages[$index]->user;
    		$messages[$index]->conversation;

            if ($messages[$index]->type == 1) {
                $messages[$index]->message = url(Storage::url($messages[$index]->message));
            }
    	}

    	return response()->json($messages);
    }

    public function sentMessage(Request $request)
    {
        
    	$request->validate([
    		'user' => 'required',
    	]);

    	$userLogged = Auth::user();
    	$userTo = User::find($request->user);

    	$conversation = $this->getConversation($request->conversation, $userTo);

    	if (!$conversation) {
    		$conversation = $this->createConversation($userTo);
    	}

        switch ($request->type) {
            case 1:
                $request->validate([
                    'image' => 'image'
                ]);

                $message = $request->image->store('public/images/messages');
            break;
            
            default:
                $message = $request->message;
                break;
        }

        $message = $conversation->messages()->create([
            'user_id' => $userLogged->id,
            'message' => $message,
            'type'    => $request->type
        ]);

        $message->user;

        if ($message->type == 1) {
            $message->message = url(Storage::url($message->message));
        }

        $message->conversation->users;

        $redis = LRedis::connection();
        $redis->publish('message', $message);

        return response()->json($conversation);
    }

    public function createConversation(User $userTo)
    {
        $conversation = Conversation::create();

        $conversation->users()->sync([
            Auth::user()->id,
            $userTo->id
        ]);

        return $conversation;
    }

    public function getConversation($conversation = null, User $userTo)
    {
        if (!$conversation) {
            $userLogged = Auth::user();

            $conversation = $userLogged->conversations->first(function ($conversation) use ($userTo) {
                if ($conversation->users()->where('user_id', $userTo->id)->first()) {
                    return true;
                }
            });
        }else{
            $conversation = Conversation::find($conversation['id']);
        }

        return $conversation;
    }
}
