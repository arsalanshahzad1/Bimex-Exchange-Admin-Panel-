<?php

namespace App\Http\Controllers\Api\Binance\Future;

use App\Http\Controllers\Controller;
use App\Http\Services\Binance\Future\OrderService;
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
    //modify order
    public function modifyOrder(Request $req)
    {
        $user = Auth::user();
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        return $this->order->modifyOrder($params, $keys);
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
    // auto cancel all order
    public function autoCancelAllOrder(Request $req)
    {
        $user = Auth::user();
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        return $this->order->autoCancelAllOrder($params, $keys);
    }
    // get user open orders
    public function getOpenOrders(Request $req)
    {
        $user = Auth::user();
        $params = $req->all();
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
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];

        return $this->order->getAllOrders($params, $keys);
    }
    // get my trades
    public function getMyTrades(Request $req)
    {
        $user = Auth::user();
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];

        return $this->order->getMyTrades($params, $keys);
    }
    // get user force order
    public function getForceOrders(Request $req)
    {
        $user = Auth::user();
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];

        return $this->order->getForceOrders($params, $keys);
    }
}
