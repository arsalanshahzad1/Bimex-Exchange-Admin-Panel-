<?php

namespace App\Http\Services\Binance\Spot;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderService
{
    private $BASE_URL;

    public function __construct()
    {
        $this->BASE_URL = env("BINANCE_BASE_URL");
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
    // cancel order 
    public function cancelOrder($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "api/v3/order?";
            $hash = signature($params, $keys['secret']);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                'X-MBX-APIKEY' => $keys['api']
            ])->asForm()->delete($url . $query . '&signature=' . $sign);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, $e->getMessage(), []);
        }
    }
    // cancel all order 
    public function cancelAllOrder($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "api/v3/openOrders?";
            $hash = signature($params, $keys['secret']);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                'X-MBX-APIKEY' => $keys['api']
            ])->asForm()->delete($url . $query . '&signature=' . $sign);
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
            $url = $this->BASE_URL . "api/v3/openOrders?";
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
}
