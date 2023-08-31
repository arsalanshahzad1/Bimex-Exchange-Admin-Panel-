<?php

namespace App\Http\Controllers\Api\Binance\Spot;

use App\Http\Controllers\Controller;
use App\Http\Services\Binance\Spot\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\VerificationDetails;

class OrderController extends Controller
{
    private $order;

    public function __construct()
    {
        $this->order = new OrderService();
    }
    // store new order 
    public function newOrder(Request $req)
    {
        $user = Auth::user();
        $kyc=true;
        $verificationDetails=VerificationDetails::where('user_id',$user->id)->get();
        $drivecheck=checkUserKyc($user->id,KYC_DRIVING_REQUIRED,'Profile');
        $passportcheck=checkUserKyc($user->id,KYC_PASSPORT_REQUIRED,'Profile');
        $nidcheck=checkUserKyc($user->id,KYC_NID_REQUIRED,'Profile');
        if($nidcheck['success']==true && $passportcheck['success']==true && $drivecheck['success']==true){
            $kyc=true;
        }
        else{
            $kyc=false;
        }
        if($kyc==false)
        {
            return binanceResponse(false,"Your KYC isn't Verified Yet!", []);
        }
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        return $this->order->createOrder($params, $keys);
    }
    // cancel order 
    public function cancelOrder(Request $req)
    {
        $user = Auth::user();
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        return $this->order->cancelOrder($params, $keys);
    }
    // cancel all order 
    public function cancelAllOrder(Request $req)
    {
        $user = Auth::user();
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        return $this->order->cancelAllOrder($params, $keys);
    }
    // get user open orders
    public function getOpenOrders(Request $req)
    {
        $user = Auth::user();
        $params = [
            'symbol' => $req->symbol,
        ];
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];

        return $this->order->getOpenOrders($params, $keys);
    }
    // get user all orders
    public function getAllOrders(Request $req)
    {
        $user = Auth::user();
        $params = [
            'symbol' => $req->symbol
        ];
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];

        return $this->order->getAllOrders($params, $keys);
    }
}
