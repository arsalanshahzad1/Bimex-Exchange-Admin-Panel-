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

    public function allCoinsInformation($params = []) {
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
}