<?php

namespace App\Http\Services\Binance;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class KlineService
{
    private $BASE_URL;

    public function __construct()
    {
        $this->BASE_URL = env("BINANCE_BASE_URL");
    }

    public function getKline($params = [])
    {
        try {
            $url = $this->BASE_URL."api/v3/uiKlines?";
            $query = http_build_query($params);
            $response = Http::get($url . $query);
            $data = $response->json();
            return [
                'data' => $data,
                'dataType'=>"own",
                'success' => true,
                'message' => 'Success'
            ];
        } catch (\Exception $e) {
            return [
                'data' => [],
                'dataType'=>"own",
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

    }
}
