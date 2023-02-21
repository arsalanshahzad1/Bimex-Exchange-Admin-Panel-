<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\Logger;
use App\Model\Friend;
use App\Model\Friendship;
use App\Model\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FriendshipController extends Controller
{
    public $logger;
    public function __construct()
    {
        $this->logger = new Logger();
    }
    public function testSignals()
    {
        $channel_name = 'test';
        $event_name = 'testing';
        $web = sendDataThroughWebSocket($channel_name,$event_name,'test');
    }
    public function index(Request $req)
    {
        $message_list = Friendship::getChatList(Auth::id());
        return response()->json([
            'success' => true,
            'message' => 'Success.',
            'data' => $message_list
        ]);
    }
    public function store(Request $req)
    {
        DB::beginTransaction();
        try {
            $friendship = Friendship::store(Auth::id());
            $friend_1 = Friend::store($friendship->id,Auth::id(), '2');
            $friend_2 = Friend::store($friendship->id,$req->user_id, '2');
            Message::createMessage($friendship->id,Auth::id(),'Hi');
            sendDataThroughWebSocket('chat','chat_list'.$req->user_id,Friendship::getChatList($req->user_id));
            sendDataThroughWebSocket('chat','user_list'.$req->user_id,Friendship::getAllUsers($req->user_id));
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Success.',
                'data' => $friendship
            ]);
        } catch (\Exception $e) {
            $this->logger->log('friendShip', $e->getMessage());
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'something goes wrong.'
            ]);
        }
    }
    public function getAllUsers()
    {
        $users = Friendship::getAllUsers(Auth::id());
        return response()->json([
            'success' => true,
            'message' => 'Success.',
            'data' => $users
        ]);
    }

    public function getSingleChat(Request $req)
    {
        Message::updateMessageSeenStatus($req->friendship_id,Auth::id());
        $friend = Message::getChat($req->friendship_id,Auth::id());
        return response()->json([
            'success' => true,
            'message' => 'Success.',
            'data' => $friend
        ]);
    }

    public function sendChat(Request $req)
    {
        try {
            $message = Message::createMessage($req->friendship_id,Auth::user()->id,$req->body);
            $chat = Message::where('id',$message->id)->first();
            sendDataThroughWebSocket('chat','chat_list'.$req->user_id,Friendship::getChatList($req->user_id));
            sendDataThroughWebSocket('chat','chatting'.$req->user_id,Message::getChat($req->friendship_id,$req->user_id));
            return response()->json([
                'success' => true,
                'message' => 'Success.',
                'data' => $chat
            ]);
        } catch (\Exception $e) {
            
        }
    }
    
}
