<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function friendship()
    {
        return $this->belongsTo(Friendship::class, 'friendship_id', 'id');
    }

    public function friend()
    {
        return $this->hasMany(Friend::class, 'friendship_id', 'friendship_id')->with('user');
    }

    public static function createMessage($friendship_id,$user_id,$body)
    {
        $message = new Message;
        $message->friendship_id = $friendship_id;
        $message->user_id = $user_id;
        $message->body = $body;
        $message->save();
        return $message;
    }

    public static function getChat($friendship_id,$user_id)
    {
        $friend = Friend::with('user')->where([
            ['user_id','!=',$user_id],
            ['friendship_id',$friendship_id]
        ])->first();
        $friend->chats = Message::where('friendship_id',$friendship_id)->get();
        return $friend;
    }

    public static function updateMessageSeenStatus($friendship_id,$user_id)
    {
        Message::where([
            ['user_id','!=',$user_id],
            ['friendship_id',$friendship_id],
        ])->update(['is_seen'=>'1']);
    }

    public static function getAllUnreadMessagesCount(){
        $friendship_id = Friend::where('user_id',Auth::user()->id)->pluck('friendship_id');
        $message = Message::where([
            ['user_id','!=',Auth::user()->id],
            ['is_seen','0'],
        ])->whereIn('friendship_id',$friendship_id)->count();
        return $message;
    }
}
