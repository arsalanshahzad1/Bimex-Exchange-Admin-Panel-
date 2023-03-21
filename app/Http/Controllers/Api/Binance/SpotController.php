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

    public function buyCrypto(Request $request) {
        try {
        // Set up the API endpoint URL
        $url = 'https://testnet.binance.vision/v3/payments/binance/pay';
    
        // Set up the headers
        $headers = [
            'Content-Type' => 'application/json',
            'X-MBX-APIKEY' => 'HSd5UxouxcMHJagTw4PC4anAyVZYl9ZacWoe2b1W5pmjiDcjpcwy2IiL3eWMsmvx'
        ];
    
        // Set up the request parameters
        $payload = [
            'coin' => 'BTC', // The cryptocurrency you want to buy
            'amount' => 100, // The amount of cryptocurrency you want to buy (in USD)
            'currency' => 'USD', // The currency you are using to make the purchase
            'return_url' => 'https://yourwebsite.com/return', // The URL to redirect users to after the purchase is complete
            'card_number' => 'your_card_number', // The credit/debit card number
            'card_expiry_month' => 'your_card_expiry_month', // The credit/debit card expiry month (in MM format)
            'card_expiry_year' => 'your_card_expiry_year', // The credit/debit card expiry year (in YYYY format)
            'card_cvv' => 'your_card_cvv', // The credit/debit card CVV number
            'card_holder_name' => 'your_card_holder_name', // The name of the card holder
            'card_holder_email' => 'your_card_holder_email', // The email of the card holder
        ];
    
        // Send the request
        $response = Http::withHeaders($headers)->post($url, $payload);
    
        // Check the response status code
        if ($response->status() == 200) {
            // The purchase was successful, handle the response data as needed
            $responseData = $response->json();
            return response()->json(['success'=>true,'data'=>$responseData]);
        } else {
            // The purchase was unsuccessful, handle the error as needed
            $errorData = $response->json();
            return response()->json(['success'=>false,'data'=>$errorData]);
        }
        } catch (\Exception $e) {
            return $e;
        }
    }
}
