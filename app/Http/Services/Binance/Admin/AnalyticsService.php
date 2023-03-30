<?php

namespace App\Http\Services\Binance\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AnalyticsService
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
    // get total user coin in btc
    public function getTotalUserCoin($params = [])
    {
        try {
            $url = $this->BASE_URL . "sapi/v1/sub-account/spotSummary?";
            $hash = signature($params, $this->SECRET);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders(['X-MBX-APIKEY' => $this->KEY])
                ->get($url . $query . '&signature=' . $sign);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            $data = collect($data['spotSubUserAssetBtcVoList'])->sum(function ($wallet) {
                return $wallet['totalAsset'];
            });
            $data = number_format($data, 8, '.', '');
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, $e->getMessage(), []);
        }
    }

        // get total user coin in btc
        public function test($params = [])
        {
            try {
                $url = $this->BASE_URL . "sapi/v1/capital/deposit/hisrec?";
                $hash = signature($params, $this->SECRET);
                $query = $hash['query'];
                $sign = $hash['sign'];
                $response = Http::withHeaders(['X-MBX-APIKEY' => $this->KEY])
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
