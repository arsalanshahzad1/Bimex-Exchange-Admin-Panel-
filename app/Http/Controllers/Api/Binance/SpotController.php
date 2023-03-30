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
    // get chart data 
    public function getChartData(Request $req)
    {
        $params = [
            'symbol'=>$req->pair,
            'interval'=>getInverval($req->interval),
            'limit'=>1000,
        ];
        if($req->start_time){
            $params['startTime'] = $req->start_time;
        }
        if($req->end_time){
            $params['endTime'] = $req->end_time;
        }
        $response = $this->spot->getKline($params);
        return response()->json($response);
    }
    // get exchange pais info 
    public function exchangeInfo(Request $req)
    {
        $params = [];
        if($req->symbol){
            $params['symbol'] = $req->symbol;
        }
        $response = $this->spot->getExchangeInfo($params);
        return response()->json($response);
    }
    // get order book 
    public function orderBook(Request $req)
    {
        $response = $this->spot->getOrderBook([
            'symbol' => $req->symbol
        ]);
        return response()->json($response);
    }
    // get 24 ticker 
    public function get24Ticker(Request $req)
    {
        $params = [];
        if($req->symbol){
            $params['symbol'] = str_replace('_', '', $req->symbol);
        }
        $response = $this->spot->get24Ticker($params);
        if($response['success']){
            $collect =  collect($response['data']);
            if($req->search){
                $response['data'] = $collect->filter(function ($item) use ($req) {
                    $str = $item['symbol'];
                    $search = substr($str, -strlen($req->search));
                    $coin = substr($str, strlen($req->search));
                    if ($search == $req->search) {
                        return true;
                    }
                });
                $response['data'] = array_values(json_decode($response['data'],true));
            }
        }
        $response['data'] = array_slice($response['data'], 0, 10);
        return response()->json($response);
    }
    // get price ticker 
    public function getPriceTicker(Request $req)
    {
        $response = $this->spot->getPriceTicker([
            'symbol' => $req->symbol
        ]);
        return response()->json($response);
    }
    // get user trade history
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
    // get market trade history
    public function getMarketTradeHistory(Request $req)
    {
        $params = [
            'symbol'=>$req->symbol
        ];
        return $this->spot->getMarketTradeHistory($params);
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

    public function socket(Request $req)
    {
        // try {
        //     $timestamps = milliseconds();
        //     $params = [
        //         'method'=>'POST',
        //         'path'=>'/api/v3/userDataStream',
        //         'data'=>'',
        //         'recvWindow'=>5000,
        //         'timestamp'=>$timestamps
        //     ];
        //     $signature = hash_hmac('sha256', http_build_query($params), env('BROKER_SECRET'));
        //     $data = [
        //         'signature' => $signature,
        //         'recvWindow' => 5000,
        //         'timestamp'=>$timestamps,
        //         'api_key' => env('BROKER_API_KEY')
        //     ];
        //     return binanceResponse(true, 'Success.', $data);
        // } catch (\Exception $e) {
        //     return binanceResponse(false, $e->getMessage(), []);
        // }
        $params = [
            'symbol' => 'BTCUSDT'
        ];
        $hash = signature($params, env('BROKER_API_SECRET'));
        $query = $hash['query'];
        $sign = $hash['sign'];
        $data = [
            'signature' => $sign,
            'query' => $query,
            'api_key' => env('BROKER_API_KEY')
        ];
        return binanceResponse(true, 'Success.', $data);
    }
}
