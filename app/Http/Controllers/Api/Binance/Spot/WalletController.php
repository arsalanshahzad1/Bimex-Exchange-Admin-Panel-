<?php

namespace App\Http\Controllers\Api\Binance\Spot;

use App\Http\Controllers\Controller;
use App\Http\Services\Binance\Spot\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\WithdrawRequestMain;

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
    // get spot & fiat balance
    public function getSpotAndFiatBalance(Request $req){
        $user = Auth::user();
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key,
            'sub_account_id'=>$user->sub_account_id
        ];
        return $this->wallet->getSpotAndFiatBalance($params, $keys);
    }
    public function allCoinInformation(Request $req)
    {

        try {
            $user = Auth::user();
            $url = $this->BASE_URL . "/sapi/v1/capital/config/getall?";
            $queryParams = $req->all();
            $queryParams['recvWindow']=5000;
            $hash = signature($queryParams, $user->secret_key);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders(['X-MBX-APIKEY' => $user->api_key])
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
            'email'=>$user->broker_email
        ];
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        return $this->wallet->depositSubAddress($params, $keys);
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

    public function getBalanceInfo(Request $req)
    {
        $user = Auth::user();
        $params = [
            // 'symbol'=>$req->symbol
        ];
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        $info =$this->wallet->getAccountInfo($params, $keys);
        $response=array();
        foreach($info['data']['balances'] as $balance)
        {
            if(strtolower($req->coin1)==strtolower($balance['asset'])){
                array_push($response,$balance);    
            }
            if(strtolower($req->coin2)==strtolower($balance['asset'])){
                array_push($response,$balance);    
            }

        }
        return binanceResponse(true,"Success!",$response);
    }
    // apply for withdraw
    public function applyForWithdraw(Request $req)
    {
        $user = Auth::user();
        $params = $req->all();
        $transfer=$this->wallet->applyForWithdrawTransfer([
            "asset"=>$params['coin'],
            "amount"=>$params['amount'],
            "type"=>$params['walletType'],
            "fromId"=>$user->sub_account_id
        ]);
        if($transfer==true){
            WithdrawRequestMain::create([
                "user_id"=>$user->id,
                "asset"=>$params['coin'],
                "amount"=>$params['amount'],
                "address"=>$params['address']
            ]);
        }
        
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
        $params['email']=$user->broker_email;
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        return $this->wallet->transfer($params, $keys);
    }
    // Daily Account Snapshot
    public function getAccountSnapshot(Request $req)
    {
        $user = Auth::user();
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        return $this->wallet->getAccountSnapshot($params, $keys);
    }
    public function enableSwitch(Request $req) 
    {
        $user = Auth::user();
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        //return "HERE";
        return $this->wallet->enableWithdraw($params, $keys);
    }
}
