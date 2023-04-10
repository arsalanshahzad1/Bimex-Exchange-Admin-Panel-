<?php

namespace App\Http\Controllers\Api\Binance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class StripeController extends Controller
{
    public function stripe()
    {
        return view('test');
    }
    public function index(Request $req)
    {
        try {
            $stripe = new StripeClient('sk_test_51MrELiBeSIRIvHDZKzeMyGqVuWIYtkR04YZZQMkJAoKIsdCTxFtovOFf6XLrRUqCgmm0HA4cEiadq3u43uKs9HAJ00D0BwqbMz');
            // Create an OnrampSession with amount and currency
            $params = [
              'transaction_details' => [
                'destination_currency' => $req->destination_currency,
                'destination_exchange_amount' => $req->destination_exchange_amount,
                'destination_network' => $req->destination_network,
              ],
              'customer_ip_address' => $_SERVER['REMOTE_ADDR']
            ];
            $onrampSession = $stripe->request('post', '/v1/crypto/onramp_sessions', $params, []);
            $output = [
                'clientSecret' => $onrampSession->client_secret,
            ];
            return binanceResponse(true,'Success.',$output);
        } catch (\Exception $e) {
            return binanceResponse(false,$e->getMessage(),[]);
        }
    }
}
