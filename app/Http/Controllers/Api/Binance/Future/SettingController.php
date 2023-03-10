<?php

namespace App\Http\Controllers\Api\Binance\Future;

use App\Http\Controllers\Controller;
use App\Http\Services\Binance\Future\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    private $setting;

    public function __construct()
    {
        $this->setting = new SettingService();
    }
    // change position mode 
    public function changePositionMode(Request $req)
    {
        $user = Auth::user();
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        return $this->setting->changePositionMode($params, $keys);
    }
    // get position mode 
    public function getPositionMode(Request $req)
    {
        $user = Auth::user();
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        return $this->setting->getPositionMode($params, $keys);
    }
    // change Multi-Assets Mode 
    public function changeMultiAssetMode(Request $req)
    {
        $user = Auth::user();
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        return $this->setting->changeMultiAssetMode($params, $keys);
    }
    // get Multi-Assets Mode
    public function getMultiAssetMode(Request $req)
    {
        $user = Auth::user();
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        return $this->setting->getMultiAssetMode($params, $keys);
    }
    // Change Initial Leverage
    public function changeInitialLeverage(Request $req)
    {
        $user = Auth::user();
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        return $this->setting->changeInitialLeverage($params, $keys);
    }
    // Change Margin Type
    public function changeMarginType(Request $req)
    {
        $user = Auth::user();
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        return $this->setting->changeMarginType($params, $keys);
    }
    // Modify Isolated Position Margin  
    public function modifyPositionMargin(Request $req)
    {
        $user = Auth::user();
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        return $this->setting->modifyPositionMargin($params, $keys);
    }
    // Get Position Margin Change History  
    public function getPositionMargin(Request $req)
    {
        $user = Auth::user();
        $params = $req->all();
        $keys = [
            'api' => $user->api_key,
            'secret' => $user->secret_key
        ];
        return $this->setting->getPositionMargin($params, $keys);
    }
}
