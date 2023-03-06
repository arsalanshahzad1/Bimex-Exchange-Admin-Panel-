<?php

namespace App\Http\Controllers\Api\Binance;

use App\Http\Controllers\Controller;
use App\Http\Services\Binance\SpotTradeService;
use App\Http\Services\Binance\TestService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use TechTailor\BinanceApi\BinanceAPI;

class SpotController extends Controller
{
    private $spot;

    public function __construct()
    {
        $this->spot = new SpotTradeService();
    }
    public function exchangeInfo(Request $req)
    {
        $params = [];
        if($req->symbol){
            $params['symbol'] = $req->symbol;
        }
        $response = $this->spot->getExchangeInfo($params);
        return response()->json($response);
    }
    public function orderBook(Request $req)
    {
        $response = $this->spot->getOrderBook([
            'symbol' => str_replace('_', '', $req->symbol)
        ]);
        return response()->json($response);
    }

    public function get24Ticker(Request $req)
    {
        $params = [];
        if($req->symbol){
            $params['symbol'] = str_replace('_', '', $req->symbol);
        }
        $response = $this->spot->get24Ticker($params);
        return response()->json($response);
    }

    public function newOrder(Request $req)
    {
        $user = Auth::user();
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        return $this->spot->createOrder($params, $keys);
    }

    public function getOpenOrders(Request $req)
    {
        $user = Auth::user();
        $params = [
            'symbol'=>$req->symbol,
            // 'origClientOrderId'=>'myOrder1'
        ];
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];

        return $this->spot->getOpenOrders($params, $keys);
    }

    public function getAllOrders(Request $req)
    {
        $user = Auth::user();
        $params = [
            'symbol'=>$req->symbol
        ];
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];

        return $this->spot->getAllOrders($params, $keys);
    }

    public function getMyTradeHistory(Request $req)
    {
        $user = Auth::user();
        $params = [
            'symbol'=>$req->symbol
        ];
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];

        return $this->spot->getMyTradeHistory($params, $keys);
    }

    public function subAccountSpotSummery(Request $req)
    {
        $params = $req->all();
        $keys = [
            'api' => env('BROKER_API_KEY'),
            'secret' => env('BROKER_SECRET')
        ];
        return $this->spot->subAccountSpotSummery($params, $keys);
    }

    // public function getAccountInfo(Request $req)
    // {
    //     $user = Auth::user();
    //     $params = [
    //         'symbol'=>$req->symbol
    //     ];
    //     $keys = [
    //         'api' => $user->api_key,
    //         'secret' => $user->secret_key
    //     ];
    //     return $this->spot->getAccountInfo($params, $keys);
    // }

}
