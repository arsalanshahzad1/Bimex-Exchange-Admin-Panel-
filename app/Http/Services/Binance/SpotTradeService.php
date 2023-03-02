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
            $url = $this->BASE_URL."api/v3/exchangeInfo?";
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
            $url = $this->BASE_URL."api/v3/depth?";
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
}
