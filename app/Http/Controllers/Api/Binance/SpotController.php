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
use Illuminate\Support\Str;

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
        $response = $this->spot->getKline([
            'symbol'=>$req->pair,
            'interval'=>getInverval($req->interval),
            'limit'=>1000,
            'startTime'=>$req->start_time,
            'endTime'=>$req->end_time,
        ]);
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
        $symbols=$response['data']['symbols'];
        $page_size=$req->page_size??120;
        $page=$req->page??1;
        $skip=($page-1)*$page_size;
        $total=count($response['data']['symbols']);
        $total_pages =ceil($total / $page_size);
        $newSymbols=array();
        for($i=$skip;$i<($skip+$page_size);$i++)
        {
            if($i<$total){
                array_push($newSymbols,$symbols[$i]);
            }
            
        }
        $response['data']['symbols']=$newSymbols;
        $pagination = [
            'total'=>$total,
            'page'=>$page,
            'page_size'=>$page_size,
            'total_pages'=>$total_pages,
            'remaining' =>$total_pages - $page,
            'next_page' => $total_pages > $page ? $page + 1 : $total_pages,
            'prev_page' => $page > 1 ? $page - 1 : 1,
        ];
        if(isset($req->search_key) && $req->search_key !=NULL && $req->search_key !="")
        {
            $newSymbols=array();
            $returnSymbols=array();
            foreach($symbols as $symbol)
            {
                if(Str::contains(strtolower($symbol['symbol']),strtolower($req->search_key))){
                    array_push($newSymbols,$symbol);
                }
                else if(Str::contains(strtolower($symbol['baseAsset']),strtolower($req->search_key))){
                    array_push($newSymbols,$symbol);
                }
            }
            for($i=$skip;$i<($skip+$page_size);$i++)
            {
                if($i<count($newSymbols)){
                    array_push($returnSymbols,$newSymbols[$i]);
                }
            }
            $response['data']['symbols']=$returnSymbols;
            $total=count($newSymbols);
            $total_pages =ceil($total / $page_size);
            $pagination = [
            'total'=>$total,
            'page'=>$page,
            'page_size'=>$page_size,
            'total_pages'=>$total_pages,
            'remaining' =>$total_pages - $page,
            'next_page' => $total_pages > $page ? $page + 1 : $total_pages,
            'prev_page' => $page > 1 ? $page - 1 : 1,
            ];
        }
        $response['data']['pagination']=$pagination;
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

}
