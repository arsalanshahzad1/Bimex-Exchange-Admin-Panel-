<?php

namespace App\Http\Services\Binance\Spot;

use App\Http\Services\Binance\SpotTradeService;
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

    public function allCoinsInformation($params = [])
    {
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

    public function depositAddress($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "/sapi/v1/capital/deposit/address?";
            $hash = signature($params, $keys['secret']);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders(['X-MBX-APIKEY' => $keys['api']])
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

    // get user account info 
    public function getAccountInfo($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "api/v3/account?";
            $hash = signature($params, $keys['secret']);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders(['X-MBX-APIKEY' => $keys['api']])
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
    // get spot & fiat balance 
    public function getSpotAndFiatBalance($params = [], $keys = [])
    {
        try {
            $spotTotalBalance = 0;
            $fiatTotalBalance = 0;
            $response = [];
            $wallet_type = explode(",", $params['type']);
            $spot = new SpotTradeService();
            $wallet = $this->getAccountInfo([], $keys)['data'];
            $balances = $wallet['balances'];
            $pairs = $spot->get24Ticker([])['data'];
            $prices = collect($pairs)->keyBy('symbol')->map(function ($price) {
                return $price['lastPrice'];
            });
            $btcPrice = $prices->get('BTCUSDT', 0);
            if (in_array('SPOT', $wallet_type)) {
                // get spot balance 
                $spotTotalBalance = array_reduce($balances, function ($total, $balance) use ($prices) {
                    $symbol = "{$balance['asset']}BTC";
                    $price = $prices->get($symbol, 0);
                    return $total + ($balance['free'] + $balance['locked']) * $price;
                }, 0);
                $response['spotBalance'] = $spotTotalBalance;
                $response['spotBalanceInDollar'] = $spotTotalBalance * $btcPrice;
            }
            if (in_array('FIAT', $wallet_type)) {
                // get fiat balance 
                $btcBalance = 0;
                $usdtBalance = 0;
                $fiat_balances = collect($balances)
                    ->filter(function ($balance) use ($btcBalance, $usdtBalance) {
                        if ($balance['asset'] == 'BTC' && $balance['asset'] == 'USDT') {
                            if ($balance['asset'] !== 'BTC') {
                                $btcBalance = $balance['free'] + $balance['locked'];
                            } else if ($balance['asset'] !== 'USDT') {
                                $usdtBalance = $balance['free'] + $balance['locked'];
                            }
                            return false;
                        } else {
                            return true;
                        }
                    });
                $fiatTotalBalance = $fiat_balances->sum(function ($balance) use ($prices) {
                    $symbol = "{$balance['asset']}BTC";
                    $price = $prices->get($symbol, 0);
                    return ($balance['free'] + $balance['locked']) * $price;
                });
                $fiatTotalBalance += $usdtBalance * (1 / $btcPrice) + $btcBalance;
                $response['fiatBalance'] = $fiatTotalBalance;
                $response['fiatBalanceInDollar'] = $fiatTotalBalance * $btcPrice;
            }
            return binanceResponse(true, 'Success.', $response);
        } catch (\Exception $e) {
            return binanceResponse(false, $e->getMessage(), []);
        }
    }
    // apply for withdraw
    public function applyForWithdraw($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "sapi/v1/capital/withdraw/apply?";
            $hash = signature($params, $keys['secret']);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders([
                'X-MBX-APIKEY' => $keys['api']
            ])->asForm()->post($url . $query . '&signature=' . $sign);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, $e->getMessage(), []);
        }
    }

    // transfer
    public function transfer($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "sapi/v1/futures/transfer?";
            $hash = signature($params, $keys['secret']);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders([
                'X-MBX-APIKEY' => $keys['api']
            ])->asForm()->post($url . $query . '&signature=' . $sign);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, $e->getMessage(), []);
        }
    }
    // Daily Account Snapshot
    public function getAccountSnapshot($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "sapi/v1/accountSnapshot?";
            $hash = signature($params, $keys['secret']);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders(['X-MBX-APIKEY' => $keys['api']])
                ->get($url . $query . '&signature=' . $sign);
            $data = $response->json();
            if (isset($data["code"]) && $data["code"] != 200) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data['snapshotVos']);
        } catch (\Exception $e) {
            return binanceResponse(false, $e->getMessage(), []);
        }
    }
}
