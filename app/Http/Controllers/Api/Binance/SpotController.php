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
        $response = $this->spot->getExchangeInfo([
            'symbol' => "ETHBTC"
        ]);
        return response()->json($response);
    }
    public function orderBook(Request $req)
    {
        $response = $this->spot->getOrderBook([
            'symbol' => $req->symbol
        ]);
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


}
