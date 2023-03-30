<?php

namespace App\Http\Services\Binance;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FutureTradeService
{
    private $BASE_URL;

    public function __construct()
    {
        $this->BASE_URL = env("BINANCE_FUTURE_BASE_URL");
    }
    // get chart data 
    public function getKline($params = [])
    {
        try {
            $url = $this->BASE_URL . "fapi/v1/klines?";
            $query = http_build_query($params);
            $response = Http::get($url . $query);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, 'Error', $e->getMessage());
        }
    }
    // indexPriceKlines
    public function getIndexPriceKlines($params = [])
    {
        try {
            $url = $this->BASE_URL . "fapi/v1/indexPriceKlines?";
            $query = http_build_query($params);
            $response = Http::get($url . $query);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, 'Error', $e->getMessage());
        }
    }
    // markPriceKlines
    public function getMarkPriceKlines($params = [])
    {
        try {
            $url = $this->BASE_URL . "fapi/v1/markPriceKlines?";
            $query = http_build_query($params);
            $response = Http::get($url . $query);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, 'Error', $e->getMessage());
        }
    }
    // get exchange info 
    public function getExchangeInfo($params = [])
    {
        try {
            $url = $this->BASE_URL . "fapi/v1/exchangeInfo?";
            $query = http_build_query($params);
            $response = Http::get($url . $query);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            $data['symbols'] = collect($data['symbols'])->firstWhere('symbol', $params['symbol']);
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, 'Error', $e->getMessage());
        }
    }
    // get coin premium index 
    public function getPairPremiumIndex($params = [])
    {
        try {
            $url = $this->BASE_URL . "fapi/v1/premiumIndex?";
            $query = http_build_query($params);
            $response = Http::get($url . $query);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, 'Error', $e->getMessage());
        }
    }
    // get 24 ticker
    public function get24Ticker($params = [])
    {
        try {
            $url = $this->BASE_URL . "fapi/v1/ticker/24hr?";
            $query = http_build_query($params);
            $response = Http::get($url . $query);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, 'Error', $e->getMessage());
        }
    }
    // get price ticker
    public function getPriceTicker($params = [])
    {
        try {
            $url = $this->BASE_URL . "fapi/v1/ticker/price?";
            $query = http_build_query($params);
            $response = Http::get($url . $query);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, 'Error', $e->getMessage());
        }
    }

    // get order book
    public function getOrderBook($params = [])
    {
        try {
            $url = $this->BASE_URL . "fapi/v1/depth?";
            $query = http_build_query($params);
            $response = Http::get($url . $query);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, 'Error', $e->getMessage());
        }
    }
    // get market trade history
    public function getMarketTradeHistory($params = [])
    {
        try {
            $url = $this->BASE_URL . "fapi/v1/trades?";
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

}
