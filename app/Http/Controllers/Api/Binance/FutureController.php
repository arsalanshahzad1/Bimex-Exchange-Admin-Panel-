<?php

namespace App\Http\Controllers\Api\Binance;

use App\Http\Controllers\Controller;
use App\Http\Services\Binance\FutureTradeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FutureController extends Controller
{
    private $future;

    public function __construct()
    {
        $this->future = new FutureTradeService();
    }
    // get chart data 
    public function getChartData(Request $req)
    {
        $response = $this->future->getKline([
            'symbol' => $req->pair,
            'interval' => getInverval($req->interval),
            'limit' => 1000,
            'startTime' => $req->start_time,
            'endTime' => $req->end_time,
        ]);
        return response()->json($response);
    }
    // get chart data 
    public function getIndexPriceChartData(Request $req)
    {
        $response = $this->future->getIndexPriceKlines([
            'pair' => $req->pair,
            'interval' => getInverval($req->interval),
            'limit' => 1000,
            'startTime' => $req->start_time,
            'endTime' => $req->end_time,
        ]);
        return response()->json($response);
    }
    // get chart data 
    public function getMarkChartData(Request $req)
    {
        $response = $this->future->getMarkPriceKlines([
            'symbol' => $req->pair,
            'interval' => getInverval($req->interval),
            'limit' => 1000,
            'startTime' => $req->start_time,
            'endTime' => $req->end_time,
        ]);
        return response()->json($response);
    }
    // get exchange pairs info 
    public function exchangeInfo(Request $req)
    {
        $params = [];
        if ($req->symbol) {
            $params['symbol'] = $req->symbol;
        }
        $response = $this->future->getExchangeInfo($params);
        return response()->json($response);
    }
    // get coin premium index
    public function pairPremiumIndex(Request $req)
    {
        $params = [];
        if ($req->symbol) {
            $params['symbol'] = $req->symbol;
        }
        $response = $this->future->getPairPremiumIndex($params);
        return response()->json($response);
    }
    // get 24 ticker 
    public function get24Ticker(Request $req)
    {
        $params = [];
        if ($req->symbol) {
            $params['symbol'] = str_replace('_', '', $req->symbol);
        }
        $response = $this->future->get24Ticker($params);
        if ($response['success']) {
            $collect =  collect($response['data']);
            if ($req->search) {
                $response['data'] = $collect->filter(function ($item) use ($req) {
                    $str = $item['symbol'];
                    $search = substr($str, -strlen($req->search));
                    $coin = substr($str, strlen($req->search));
                    if ($search == $req->search) {
                        return true;
                    }
                });
                $response['data'] = array_values(json_decode($response['data'], true));
            }
        }
        $response['data'] = array_slice($response['data'], 0, count($response['data']) <= 10 ? count($response['data']) : 10);
        return response()->json($response);
    }
    // get price ticker 
    public function getPriceTicker(Request $req)
    {
        $response = $this->future->getPriceTicker([
            'symbol' => $req->symbol
        ]);
        return response()->json($response);
    }
    // get order book 
    public function orderBook(Request $req)
    {
        $response = $this->future->getOrderBook([
            'symbol' => $req->symbol
        ]);
        return response()->json($response);
    }
    // get market trade history
    public function getMarketTradeHistory(Request $req)
    {
        $params = [
            'symbol' => $req->symbol
        ];
        return $this->future->getMarketTradeHistory($params);
    }
    
}
