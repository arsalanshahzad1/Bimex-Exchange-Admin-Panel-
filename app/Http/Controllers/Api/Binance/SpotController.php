<?php

namespace App\Http\Controllers\Api\Binance;

use App\Http\Controllers\Controller;
use App\Http\Services\Binance\SpotTradeService;
use Illuminate\Http\Request;

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
        $params = $req->all();
        // TODO::CHANGED KEYS TO LOGGED USER API KEYS
        $keys = [
            'api' => 'I9ku4NALLA0kUvNFI5yNgCvdTBpdAwewkpQTSWuQDVqowSxyEgynui3IBIeklwEI',
            'secret' => 'kiLIE1cuOz0yChZDBywjvSu19yUfkNOlu6qhHYUOGDddj0x6I90cNppATTRAHZuk'
        ];

        return $this->spot->createOrder($params, $keys);
    }

    public function getOpenOrders(Request $req)
    {
        $params = [
            'symbol'=>$req->symbol
        ];
        // TODO::CHANGED KEYS TO LOGGED USER API KEYS
        $keys = [
            'api' => 'I9ku4NALLA0kUvNFI5yNgCvdTBpdAwewkpQTSWuQDVqowSxyEgynui3IBIeklwEI',
            'secret' => 'kiLIE1cuOz0yChZDBywjvSu19yUfkNOlu6qhHYUOGDddj0x6I90cNppATTRAHZuk'
        ];

        return $this->spot->getOpenOrders($params, $keys);
    }

    public function getAllOrders(Request $req)
    {
        $params = [
            'symbol'=>$req->symbol
        ];
        // TODO::CHANGED KEYS TO LOGGED USER API KEYS
        $keys = [
            'api' => 'I9ku4NALLA0kUvNFI5yNgCvdTBpdAwewkpQTSWuQDVqowSxyEgynui3IBIeklwEI',
            'secret' => 'kiLIE1cuOz0yChZDBywjvSu19yUfkNOlu6qhHYUOGDddj0x6I90cNppATTRAHZuk'
        ];

        return $this->spot->getAllOrders($params, $keys);
    }

    public function getMyTradeHistory(Request $req)
    {
        $params = [
            'symbol'=>$req->symbol
        ];
        // TODO::CHANGED KEYS TO LOGGED USER API KEYS
        $keys = [
            'api' => 'I9ku4NALLA0kUvNFI5yNgCvdTBpdAwewkpQTSWuQDVqowSxyEgynui3IBIeklwEI',
            'secret' => 'kiLIE1cuOz0yChZDBywjvSu19yUfkNOlu6qhHYUOGDddj0x6I90cNppATTRAHZuk'
        ];

        return $this->spot->getMyTradeHistory($params, $keys);
    }


}
