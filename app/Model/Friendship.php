<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Friendship extends Model
{
    use HasFactory;

    public function friends()
    {
        return $this->hasMany(Friend::class,'friendship_id');
    }

    public static function store($user_id)
    {
        $friendship = new Friendship;
        $friendship->creater_id = $user_id;
        $friendship->save();
        return $friendship;
    }

    public static function getChatList($user_id)
    {
        $message_list = [];
        $friendship_id = Friend::where('user_id',$user_id)->pluck('friendship_id');
        $messages = Message::with(['friend' => function($q) use($user_id) {
            $q->where('user_id', '!=', $user_id); // '=' is optional
        }])
        ->whereIn('friendship_id',$friendship_id)
        ->orderBy('id','desc')->get();
        $message_list = $messages->unique('friendship_id')->values()->all();
        return $message_list;
    }

    public static function getAllUsers($user_id)
    {
        $friendship = Friendship::whereHas('friends',function($q)use($user_id){
            $q->where('user_id',$user_id);
        })->pluck('id');
        $friend_user_ids = Friend::where('user_id','!=',$user_id)->whereIn('friendship_id',$friendship)->pluck('user_id');
        $users = User::where([
            ['id','!=',$user_id]
        ])->whereNotIn('id',$friend_user_ids)->get();
        return $users;
    }
}
