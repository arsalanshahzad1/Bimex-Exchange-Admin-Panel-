<?php

namespace App\Http\Controllers\Api\Binance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class WalletController extends Controller
{
    private $KEY;
    private $SECRET;
    private $BASE_URL;

    public function __construct()
    {
        $this->KEY = "HSd5UxouxcMHJagTw4PC4anAyVZYl9ZacWoe2b1W5pmjiDcjpcwy2IiL3eWMsmvx";
        $this->SECRET = "VNqXb1Hc4NoVp6CGwyENPI7kFxRMLAOD0RghbxoiRYU150ezr5nUm4eNfiF1MGdZ";
        $this->BASE_URL = 'https://api.binance.com/';
    }

    public function allCoinInformation(Request $req)
    {
        try {
            $url = $this->BASE_URL . "/sapi/v1/capital/config/getall?";
            $queryParams = $req->all();
            $hash = signature($queryParams, $this->SECRET);
            $query = $hash['query'];
            $sign = $hash['sign'];

            $response = Http::withHeaders(['X-MBX-APIKEY' => $this->KEY])
                ->get($url . $query . '&signature=' . $sign);

            $data = $response->json();


            if (isset($data["code"])) {
                return \Response::json($response->json(), 400);
            }

            return $response->json();
        } catch (\Exception $e) {
            $this->logger->log('allCoinInformation', $e->getMessage());
            $response = ['success' => false, 'message' => $e->getMessage(), 'data' => (object)[]];
            return response()->json($response);
        }
    }

    public function depositAddress(Request $req)
    {
        try {
            $url = $this->BASE_URL . "/sapi/v1/capital/deposit/address?";
            $queryParams = $req->all();
            $hash = signature($queryParams, $this->SECRET);
            $query = $hash['query'];
            $sign = $hash['sign'];

            $response = Http::withHeaders(['X-MBX-APIKEY' => $this->KEY])
                ->get($url . $query . '&signature=' . $sign);

            $data = $response->json();


            if (isset($data["code"])) {
                return \Response::json($response->json(), 400);
            }

            return $response->json();
        } catch (\Exception $e) {
            $this->logger->log('depositAddress', $e->getMessage());
            $response = ['success' => false, 'message' => $e->getMessage(), 'data' => (object)[]];
            return response()->json($response);
        }
    }
}
