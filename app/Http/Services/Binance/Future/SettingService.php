<?php

namespace App\Http\Services\Binance\Future;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SettingService
{
    private string $KEY;
    private string $SECRET;
    private string $BASE_URL;
    private string $BASE_SPOT_URL;

    public function __construct()
    {
        $this->KEY = env("BROKER_API_KEY");
        $this->SECRET = env("BROKER_SECRET");
        $this->BASE_URL = env("BINANCE_FUTURE_BASE_URL");
        $this->BASE_SPOT_URL = env("BINANCE_BASE_URL");
    }
    // changePositionMode 
    public function changePositionMode($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "fapi/v1/positionSide/dual?";
            $hash = signature($params, $keys['secret']);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                'X-MBX-APIKEY' => $keys['api']
            ])->asForm()->post($url . $query . '&signature=' . $sign);
            $data = $response->json();
            if (isset($data["code"]) && $data['code']!=200) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, $e->getMessage(), []);
        }
    }
    // get PositionMode
    public function getPositionMode($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "fapi/v1/positionSide/dual?";
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
    // change Multi-Assets Mode 
    public function changeMultiAssetMode($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "fapi/v1/multiAssetsMargin?";
            $hash = signature($params, $keys['secret']);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
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
    // get Multi-Assets Mode 
    public function getMultiAssetMode($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "fapi/v1/multiAssetsMargin?";
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
    // Change Initial Leverage
    public function changeInitialLeverage($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "fapi/v1/leverage?";
            $hash = signature($params, $keys['secret']);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
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
    // Change Margin Type
    public function changeMarginType($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "fapi/v1/marginType?";
            $hash = signature($params, $keys['secret']);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                'X-MBX-APIKEY' => $keys['api']
            ])->asForm()->post($url . $query . '&signature=' . $sign);
            $data = $response->json();
            if (isset($data["code"]) && $data['code']!=200) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, $e->getMessage(), []);
        }
    }
    // Modify Isolated Position Margin  
    public function modifyPositionMargin($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "fapi/v1/positionMargin?";
            $hash = signature($params, $keys['secret']);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
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
    // Get Position Margin Change History  
    public function getPositionMargin($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "fapi/v1/positionMargin/history?";
            $hash = signature($params, $keys['secret']);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                'X-MBX-APIKEY' => $keys['api']
            ])->get($url . $query . '&signature=' . $sign);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, $e->getMessage(), []);
        }
    }
    // Get Position Information
    public function getPositionInformation($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "fapi/v2/positionRisk?";
            $hash = signature($params, $keys['secret']);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                'X-MBX-APIKEY' => $keys['api']
            ])->get($url . $query . '&signature=' . $sign);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, $e->getMessage(), []);
        }
    }
    public function getTransactionHistory($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "fapi/v1/userTrades?";
            $hash = signature($params, $keys['secret']);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                'X-MBX-APIKEY' => $keys['api']
            ])->get($url . $query . '&signature=' . $sign);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, $e->getMessage(), []);
        }
    }
    // Get Leverage Brackets
    public function getLeverageBrackets($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "fapi/v1/leverageBracket?";
            $hash = signature($params, $keys['secret']);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                'X-MBX-APIKEY' => $keys['api']
            ])->get($url . $query . '&signature=' . $sign);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, $e->getMessage(), []);
        }
    }
    // Get Position ADL
    public function getPositionADL($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "fapi/v1/adlQuantile?";
            $hash = signature($params, $keys['secret']);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                'X-MBX-APIKEY' => $keys['api']
            ])->get($url . $query . '&signature=' . $sign);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, $e->getMessage(), []);
        }
    }
    // Get Trading rules
    public function getTradingRules($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "fapi/v1/apiTradingStatus?";
            $hash = signature($params, $keys['secret']);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                'X-MBX-APIKEY' => $keys['api']
            ])->get($url . $query . '&signature=' . $sign);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, $e->getMessage(), []);
        }
    }
    // User Commission Rate
    public function getCommission($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "fapi/v1/commissionRate?";
            $hash = signature($params, $keys['secret']);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                'X-MBX-APIKEY' => $keys['api']
            ])->get($url . $query . '&signature=' . $sign);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, $e->getMessage(), []);
        }
    }
    // Get Download Id For Futures Transaction History
    public function getDownloadID($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "fapi/v1/income/asyn?";
            $hash = signature($params, $keys['secret']);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                'X-MBX-APIKEY' => $keys['api']
            ])->get($url . $query . '&signature=' . $sign);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, $e->getMessage(), []);
        }
    }
    // Get Download Link
    public function getDownloadLink($params = [], $keys = [])
    {
        try {
            $url = $this->BASE_URL . "fapi/v1/income/asyn/id?";
            $hash = signature($params, $keys['secret']);
            $query = $hash['query'];
            $sign = $hash['sign'];
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                'X-MBX-APIKEY' => $keys['api']
            ])->get($url . $query . '&signature=' . $sign);
            $data = $response->json();
            if (isset($data["code"])) {
                return binanceResponse(false, $data['msg'], []);
            }
            return binanceResponse(true, 'Success.', $data);
        } catch (\Exception $e) {
            return binanceResponse(false, $e->getMessage(), []);
        }
    }
}
