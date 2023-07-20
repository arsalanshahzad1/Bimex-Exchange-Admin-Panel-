<?php

namespace App\Http\Controllers\Api\Binance;

use App\Http\Controllers\Controller;
use App\Http\Services\Binance\BrokerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class BrokerController extends Controller
{
    private string $KEY;
    private string $SECRET;
    private string $BASE_URL;
    private BrokerService $broker;

    public function __construct()
    {
        $this->KEY = env("BROKER_API_KEY");
        $this->SECRET = env("BROKER_SECRET");
        $this->BASE_URL = env("BINANCE_BASE_URL");
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

    public function apiRestrictions(Request $req)
    {
        $user = Auth::user();
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        $this->broker = new BrokerService();

        return $this->broker->apiRestrictions($params, $keys);
    }

    public function apiTradingStatus(Request $req)
    {
        $user = Auth::user();
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        $this->broker = new BrokerService();
        return $this->broker->apiTradingStatus($params, $keys);
    }

    public function tradeFee(Request $req)
    {
        $user = Auth::user();
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        $this->broker = new BrokerService();
        return $this->broker->tradeFee($params, $keys);
    }

    public function myTrades(Request $req)
    {
        $user = Auth::user();
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        $this->broker = new BrokerService();
        return $this->broker->myTrades($params, $keys);
    }

    public function depositHistory(Request $req)
    {
        $user = Auth::user();
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        $this->broker = new BrokerService();
        return $this->broker->depositHistory($params, $keys);
    }

    public function withdrawHistory(Request $req)
    {
        $user = Auth::user();
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        $this->broker = new BrokerService();
        return $this->broker->withdrawHistory($params, $keys);
    }


}
