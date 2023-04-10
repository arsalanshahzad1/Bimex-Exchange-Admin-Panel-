<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use HasFactory;
    const CONSTRAINT = [
        'SPOT_MARKET' => 0,
        'FUTURE_MARKET' => 1,
        'SPOT_TRADE' => 2,
        'FUTURE_TRADE' => 3
    ];
}
