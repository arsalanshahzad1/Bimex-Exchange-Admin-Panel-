<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;

    // 0 = pending
    // 1 = requested
    // 2 = friends

    function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function friendship(){
        return $this->belongsTo(Friendship::class,'friendship_id','id');
    }
    public static function store($friendship_id,$user_id,$type)
    {
        $friend = new Friend;
        $friend->friendship_id = $friendship_id;
        $friend->user_id = $user_id;
        $friend->request_type = $type;
        $friend->save();
        return $friend;
    }
}
