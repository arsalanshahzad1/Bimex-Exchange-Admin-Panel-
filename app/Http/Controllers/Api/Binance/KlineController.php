<?php

namespace App\Http\Controllers\Api\Binance;

use App\Http\Controllers\Controller;
use App\Http\Services\Binance\KlineService;
use Illuminate\Http\Request;

class KlineController extends Controller
{
    private $kline;

    public function __construct()
    {
        $this->kline = new KlineService();
    }
    
    public function index(Request $req)
    {
        $response = $this->kline->getKline([
            'symbol'=>$req->pair,
            'interval'=>'1h',
            'limit'=>1000,
            'startTime'=>$req->start_time,
            'endTime'=>$req->end_time,
        ]);
        // $response['request'] = $req->all(); 
        return response()->json($response);
    }
}
