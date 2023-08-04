<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawRequestMain extends Model
{
    use HasFactory;

    protected $fillable=['user_id','asset','amount','address'];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}
