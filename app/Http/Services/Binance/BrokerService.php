<?php

namespace App\Http\Services\Binance;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BrokerService
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

    public function createSubAccount($params = [])
    {
        try {
            $url = $this->BASE_URL . "/sapi/v1/broker/subAccount?";
            $hash = signature($params, $this->SECRET);
            $query = $hash['query'];
            $sign = $hash['sign'];


            $response = Http::withHeaders(['X-MBX-APIKEY' => $this->KEY])->post($url . $query . '&signature=' . $sign);
            $data = $response->json();


            if (isset($data["code"])) {
                return \Response::json($response->json(), 400);
            }

            return $data;
        } catch (\Exception $e) {
            $this->logger->log('createSubAccount', $e->getMessage());
            $response = ['success' => false, 'message' => $e->getMessage(), 'data' => (object)[]];
            return $response;
        }
    }

    public function createSubAccountApiKey($params = [])
    {
        try {
            $url = $this->BASE_URL . "/sapi/v1/broker/subAccountApi?";
            $hash = signature($params, $this->SECRET);
            $query = $hash['query'];
            $sign = $hash['sign'];

            $response = Http::withHeaders(['X-MBX-APIKEY' => $this->KEY])
                ->post($url . $query . '&signature=' . $sign);

            $data = $response->json();


            if (isset($data["code"])) {
                return \Response::json($response->json(), 400);
            }

            return $response->json();
        } catch (\Exception $e) {
            $this->logger->log('createSubAccountApiKey', $e->getMessage());
            $response = ['success' => false, 'message' => $e->getMessage(), 'data' => (object)[]];
            return response()->json($response);
        }
    }
}
