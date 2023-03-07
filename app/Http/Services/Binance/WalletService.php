<?php

namespace App\Http\Services\Binance;

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
        $this->BASE_URL = env("BINANCE_BASE_URL");
    }

    public function allCoinsInformation($params = [])
    {
        $url = $this->BASE_URL . "/sapi/v1/capital/config/getall?";
        $hash = signature($params, $this->SECRET);
        $query = $hash['query'];
        $sign = $hash['sign'];

        $response = Http::withHeaders(['X-MBX-APIKEY' => $this->KEY])
            ->get($url . $query . '&signature=' . $sign);

        $data = $response->json();


        if (isset($data["code"])) {
            return \Response::json($response->json(), 400);
        }

        return $response->json();
    }

    public function depositAddress($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "/sapi/v1/capital/deposit/address?";
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
            $url = $this->BASE_URL . "api/v3/account?";
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

    // apply for withdraw
    public function applyForWithdraw($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "sapi/v1/capital/withdraw/apply?";
            $hash = signature($params, $keys['secret']);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders([
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

    // apply for withdraw
    public function transfer($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "sapi/v1/futures/transfer?";
            $hash = signature($params, $keys['secret']);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders([
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
}
