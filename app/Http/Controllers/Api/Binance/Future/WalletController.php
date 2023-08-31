<?php

namespace App\Http\Controllers\Api\Binance\Future;

use App\Http\Controllers\Controller;
use App\Http\Services\Binance\Future\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class WalletController extends Controller
{
    private object $wallet;

    public function __construct()
    {
        $this->wallet = new WalletService;
    }
    // get user future account balance
    public function getFutureAccountBalance(Request $req)
    {
        $user = Auth::user();
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        return $this->wallet->getFutureAccountBalance($params, $keys);
    }
    // get user account coins
    public function getAccountInfo(Request $req)
    {
        $user = Auth::user();
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        $data=$this->wallet->getAccountInfo($params, $keys);
        $params['subAccountId']=$user->sub_account_id;
        $newData=$this->wallet->getAccountInfoNew($params, $keys);
        $data['data']['totalWalletBalance']=$newData['data']['data'][0]['totalWalletBalanceOfUsdt'];
        return $data;
    }
    public function getAccountInfoNew(Request $req)
    {
        $user = Auth::user();
        $params = $req->all();
        $params['subAccountId']=$user->sub_account_id;
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        return $this->wallet->getAccountInfoNew($params, $keys);
    }
    // get user income history
    public function getIncomeHistory(Request $req)
    {
        $user = Auth::user();
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        return $this->wallet->getIncomeHistory($params, $keys);
    }

}
