<?php

namespace App\Http\Services\Binance\Future;

use Illuminate\Support\Facades\Http;

class WalletService
{
    private string $KEY;
    private string $SECRET;
    private string $BASE_URL;

    public function __construct()
    {
        $this->KEY = env("BROKER_API_KEY");
        $this->SECRET = env("BROKER_SECRET");
        $this->BASE_URL = env("BINANCE_FUTURE_BASE_URL");
    }
    // get user future account balance
    public function getFutureAccountBalance($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "fapi/v2/balance?";
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
    // get user account info 
    public function getAccountInfo($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "fapi/v2/account?";
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
    // get user income history
    public function getIncomeHistory($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "fapi/v1/income?";
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
