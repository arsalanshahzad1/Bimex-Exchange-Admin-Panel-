<?php

namespace App\Http\Services\Binance;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SpotTradeService
{
    private $BASE_URL;

    public function __construct()
    {
        $this->BASE_URL = env("BINANCE_BASE_URL");
    }
    // get chart data 
    public function getKline($params = [])
    {
        try {
            $url = $this->BASE_URL . "api/v3/klines?";
            $query = http_build_query($params);
            $response = Http::get($url . $query);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, 'Success', $e->getMessage());
        }
    }
    // get exchange info 
    public function getExchangeInfo($params = [])
    {
        try {
            $url = $this->BASE_URL . "api/v3/exchangeInfo?";
            $query = http_build_query($params);
            $response = Http::get($url . $query);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, 'Success', $e->getMessage());
        }
    }

    // get order book
    public function getOrderBook($params = [])
    {
        try {
            $url = $this->BASE_URL . "api/v3/depth?";
            $query = http_build_query($params);
            $response = Http::get($url . $query);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, 'Success', $e->getMessage());
        }
    }
    // get 24 ticker
    public function get24Ticker($params = [])
    {
        try {
            $url = $this->BASE_URL . "api/v3/ticker/24hr?";
            $query = http_build_query($params);
            $response = Http::get($url . $query);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, 'Success', $e->getMessage());
        }
    }
    // get price ticker
    public function getPriceTicker($params = [])
    {
        try {
            $url = $this->BASE_URL . "api/v3/ticker/price?";
            $query = http_build_query($params);
            $response = Http::get($url . $query);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, 'Success', $e->getMessage());
        }
    }
    // create new order 
    public function createOrder($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "api/v3/order?";
            $hash = signature($params, $keys['secret']);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                'X-MBX-APIKEY' => $keys['api']
            ])->asForm()->post($url . $query . '&signature=' . $sign);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, $e->getMessage(), []);
        }
    }
    // get open orders
    public function getOpenOrders($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "api/v3/order?";
            $hash = signature($params, $keys['secret']);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders(['X-MBX-APIKEY' => $keys['api']])
                ->get($url . $query . '&signature=' . $sign);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, $e->getMessage(), []);
        }
    }
    // get all orders
    public function getAllOrders($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "api/v3/allOrders?";
            $hash = signature($params, $keys['secret']);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders(['X-MBX-APIKEY' => $keys['api']])
                ->get($url . $query . '&signature=' . $sign);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, $e->getMessage(), []);
        }
    }

    // get my trade history
    public function getMyTradeHistory($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "api/v3/myTrades?";
            $hash = signature($params, $keys['secret']);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders(['X-MBX-APIKEY' => $keys['api']])
                ->get($url . $query . '&signature=' . $sign);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, $e->getMessage(), []);
        }
    }
    // get market trade history
    public function getMarketTradeHistory($params = [])
    {
        try {
            $url = $this->BASE_URL . "api/v3/trades?";
            $query = http_build_query($params);
            $response = Http::get($url . $query);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, $e->getMessage(), []);
        }
    }

    /*Broker Spot APIs*/

    // Query Sub Account Spot Asset info
    public function subAccountSpotSummery($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "/sapi/v1/broker/subAccount/spotSummary?";
            $hash = signature($params, $keys['secret']);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders(['X-MBX-APIKEY' => $keys['api']])
                ->get($url . $query . '&signature=' . $sign);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, $e->getMessage(), []);
        }
    }
}
