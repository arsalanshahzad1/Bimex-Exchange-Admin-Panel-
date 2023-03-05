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

    public function getExchangeInfo($params = [])
    {
        try {
            $url = $this->BASE_URL . "api/v3/exchangeInfo?";
            $query = http_build_query($params);
            $response = Http::get($url . $query);
            $data = $response->json();
            return [
                'data' => $data,
                'success' => true,
                'message' => 'Success'
            ];
        } catch (\Exception $e) {
            return [
                'data' => [],
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function getOrderBook($params = [])
    {
        try {
            $url = $this->BASE_URL . "api/v3/depth?";
            $query = http_build_query($params);
            $response = Http::get($url . $query);
            $data = $response->json();
            return [
                'data' => $data,
                'success' => true,
                'message' => 'Success'
            ];
        } catch (\Exception $e) {
            return [
                'data' => [],
                'success' => false,
                'message' => $e->getMessage()
            ];
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
            $data = array_slice($data, 0, 10);
            return [
                'data' => $data,
                'success' => true,
                'message' => 'Success'
            ];
        } catch (\Exception $e) {
            return [
                'data' => [],
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function createOrder($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "api/v3/order?";
            $hash = signature($params, $keys['secret']);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders(['X-MBX-APIKEY' => $keys['api']])->post($url . $query . '&signature=' . $sign);
            $data = $response->json();
            if (isset($data["code"])) {
                return [
                    'data' => $data,
                    'success' => false,
                    'message' => $data['msg']
                ];
            }
            return [
                'data' => $data,
                'success' => true,
                'message' => 'Success.'
            ];
        } catch (\Exception $e) {
            return [
                'data' => [],
                'success' => false,
                'message' => $e->getMessage()
            ];
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
                return [
                    'data' => [],
                    'success' => false,
                    'message' => $data['msg']
                ];
            }
            return [
                'data' => $data,
                'success' => true,
                'message' => 'Success.'
            ];
        } catch (\Exception $e) {
            return [
                'data' => [],
                'success' => false,
                'message' => $e->getMessage()
            ];
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
                return [
                    'data' => [],
                    'success' => false,
                    'message' => $data['msg']
                ];
            }
            return [
                'data' => $data,
                'success' => true,
                'message' => 'Success.'
            ];
        } catch (\Exception $e) {
            return [
                'data' => [],
                'success' => false,
                'message' => $e->getMessage()
            ];
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
                return [
                    'data' => [],
                    'success' => false,
                    'message' => $data['msg']
                ];
            }
            return [
                'data' => $data,
                'success' => true,
                'message' => 'Success.'
            ];
        } catch (\Exception $e) {
            return [
                'data' => [],
                'success' => false,
                'message' => $e->getMessage()
            ];
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
                return [
                    'data' => [],
                    'success' => false,
                    'message' => $data['msg']
                ];
            }
            return [
                'data' => $data,
                'success' => true,
                'message' => 'Success.'
            ];
        } catch (\Exception $e) {
            return [
                'data' => [],
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

}
