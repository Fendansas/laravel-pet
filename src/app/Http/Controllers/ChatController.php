<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Events\MessageSent;
class ChatController extends Controller
{
    public function index(Request $request){

        $user = auth()->user();
        $recipientId = $request->query('user_id');
        $conversation = Conversation::where('user_one_id', $user->id)
            ->orWhere('user_two_id', $user->id)
            ->with(['userOne', 'userTwo'])
            ->get();

        return view('chat.index', compact( 'conversation', 'recipientId'));
    }

    public function show($userId)
    {
        $authUser = auth()->user();

        $conversation = Conversation::between($authUser->id, $userId)->first();

        if (! $conversation) {
            $conversation = Conversation::create([
                'user_one_id' => $authUser->id,
                'user_two_id' => $userId,
            ]);
        }

        $messages = $conversation->messages()->with('sender')->orderBy('created_at')->get();

        return response()->json([
            'conversation' => $conversation,
            'messages' => $messages,
        ]);
    }




    public function send(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'message' => 'required|string|max:5000',
        ]);

        $authUser = auth()->user();


        $conversation = Conversation::between($authUser->id, $request->recipient_id)->first();

        if (! $conversation) {
            $conversation = Conversation::create([
                'user_one_id' => $authUser->id,
                'user_two_id' => $request->recipient_id,
            ]);
        }


        $message = $conversation->messages()->create([
            'conversation_id' => $conversation->id,
            'sender_id' => $authUser->id,
            'message' => $request->message,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['message' => $message]);
    }

}
