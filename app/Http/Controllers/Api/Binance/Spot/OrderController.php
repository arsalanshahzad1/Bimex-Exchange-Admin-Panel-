<?php

namespace App\Http\Controllers\Api\Binance\Spot;

use App\Http\Controllers\Controller;
use App\Http\Services\Binance\Spot\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
