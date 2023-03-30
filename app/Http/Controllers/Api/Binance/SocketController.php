<?php

namespace App\Http\Controllers\Api\Binance;

use App\Http\Controllers\Controller;
use App\Http\Services\Binance\SpotTradeService;
use App\Http\Services\Binance\TestService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;
class SocketController extends Controller
{
    private $spot;

    public function __construct()
    {
        $this->spot = new SpotTradeService();
    }

    public function index()
    {
        $server = new Server('0.0.0.0', 9501);
    }
}
