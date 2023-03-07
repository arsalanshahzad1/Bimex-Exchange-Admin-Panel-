<?php

namespace App\Http\Controllers\Api\Binance;

use App\Http\Controllers\Controller;
use App\Http\Services\Binance\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
class WalletController extends Controller
{
    private string $KEY;
    private string $SECRET;
    private string $BASE_URL;
    private object $wallet;

    public function __construct()
    {
        $this->KEY = env("BROKER_API_KEY");
        $this->SECRET = env("BROKER_SECRET");
        $this->BASE_URL = env("BINANCE_BASE_URL");
        $this->wallet = new WalletService;
    }

    public function allCoinInformation(Request $req)
    {
        
        
        try {
            $user = Auth::user();
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
        $user = Auth::user();
        $params = [
            'coin'=>$req->coin,
        ];
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        return $this->wallet->depositAddress($params, $keys);
    }

    public function depositHistory(Request $req)
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
    // get user account coins
    public function getAccountInfo(Request $req)
    {
        $user = Auth::user();
        $params = [
            // 'symbol'=>$req->symbol
        ];
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        return $this->wallet->getAccountInfo($params, $keys);
    }
    // apply for withdraw
    public function applyForWithdraw(Request $req)
    {
        $user = Auth::user();
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        return $this->wallet->applyForWithdraw($params, $keys);
    }
    // transfer
    public function transfer(Request $req)
    {
        $user = Auth::user();
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        return $this->wallet->transfer($params, $keys);
    }
}
