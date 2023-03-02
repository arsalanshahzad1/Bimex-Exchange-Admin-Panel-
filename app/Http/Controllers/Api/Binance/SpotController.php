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
            'symbol'=>$req->symbol
        ]);
        return response()->json($response);
    }
}
