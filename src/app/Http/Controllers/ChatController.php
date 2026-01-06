<?php

namespace App\Http\Controllers;

use App\Http\Requests\Chat\SendMessageRequest;
use App\Models\Conversation;
use App\Services\ConversationService;
use App\Services\MessageService;
use Illuminate\Http\Request;
use App\Events\MessageSent;
class ChatController extends Controller
{
    public function __construct(
        protected ConversationService $conversationService,
        protected MessageService $messageService
    ) {}

    public function index(Request $request){
        $user = auth()->user();

        $conversation = $this->conversationService->getUserConversations($user->id);

        $recipientId =  $request->query('user_id');

        return view('chat.index', compact( 'conversation', 'recipientId'));
    }

    public function show($userId)
    {
        $authUser = auth()->user();

        $conversation = Conversation::between($authUser->id, $userId)->first();


        $conversation = $this->conversationService->getOrCreateConversation($authUser->id, $userId);


        $messages = $this->messageService->getMessages($conversation);

        return response()->json([
            'conversation' => $conversation,
            'messages' => $messages,
        ]);
    }




    public function send(SendMessageRequest $request)
    {

        $authUser = auth()->user();


        $conversation = $this->conversationService->getOrCreateConversation($authUser->id, request()->recipient_id);

        $message = $this->messageService->sendMessage(
            $conversation,
            $authUser->id,
            request()->message
        );

        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['message' => $message]);
    }

}
