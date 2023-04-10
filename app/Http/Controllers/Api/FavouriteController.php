<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FavouriteRequest;
use App\Model\Favourite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    public function storeOrRemove(FavouriteRequest $req)
    {
        try {
            $type = Favourite::CONSTRAINT[$req->type];
            $favourite = Favourite::where([
                'ip_address' => $req->ip(),
                'pair' => $req->pair,
                'type' => $type
            ])->first();
            if($favourite){
                if($favourite->delete()){
                    return binanceResponse(true,'Pair successfully removed from favourite.',[]);
                }
            }
            else{
                $favourite = new Favourite();
                $favourite->ip_address = $req->ip();
                $favourite->pair = $req->pair;
                $favourite->type = $type;
                if($favourite->save()){
                    return binanceResponse(true,'Pair successfully add to favourite.',$favourite);
                }
            }
        } catch (\Exception $e) {
            return binanceResponse(false,$e->getMessage());
        }
    }
}
