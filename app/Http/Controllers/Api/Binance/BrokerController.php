<?php

namespace App\Http\Controllers\Api\Binance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BrokerController extends Controller
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

    public function createSubAccount(Request $req)
    {
        try {
            $url = $this->BASE_URL . "/sapi/v1/broker/subAccount?";
            $queryParams = $req->all();
            $hash = signature($queryParams, $this->SECRET);
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
            $this->logger->log('createSubAccount', $e->getMessage());
            $response = ['success' => false, 'message' => $e->getMessage(), 'data' => (object)[]];
            return response()->json($response);
        }
    }

    public function querySubAccount(Request $req)
    {
        try {
            $url = $this->BASE_URL . "/sapi/v1/broker/subAccount?";

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
            $this->logger->log('querySubAccount', $e->getMessage());
            $response = ['success' => false, 'message' => $e->getMessage(), 'data' => (object)[]];
            return response()->json($response);
        }
    }

    public function accountInformation(Request $req)
    {
        try {
            $url = $this->BASE_URL . "/sapi/v1/broker/info?";

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
            $this->logger->log('accountInformation', $e->getMessage());
            $response = ['success' => false, 'message' => $e->getMessage(), 'data' => (object)[]];
            return response()->json($response);
        }
    }

    public function createSubAccountApiKey(Request $req)
    {
        try {
            $url = $this->BASE_URL . "/sapi/v1/broker/subAccountApi?";

            $queryParams = $req->all();
            $hash = signature($queryParams, $this->SECRET);
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

    public function querySubAccountApiKey(Request $req)
    {
        try {
            $url = $this->BASE_URL . "/sapi/v1/broker/subAccountApi?";

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
            $this->logger->log('createSubAccountApiKey', $e->getMessage());
            $response = ['success' => false, 'message' => $e->getMessage(), 'data' => (object)[]];
            return response()->json($response);
        }
    }

    public function deleteSubAccountApiKey(Request $req)
    {
        try {
            $url = $this->BASE_URL . "/sapi/v1/broker/subAccountApi?";

            $queryParams = $req->all();
            $hash = signature($queryParams, $this->SECRET);
            $query = $hash['query'];
            $sign = $hash['sign'];

            $response = Http::withHeaders(['X-MBX-APIKEY' => $this->KEY])
                ->delete($url . $query . '&signature=' . $sign);

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
