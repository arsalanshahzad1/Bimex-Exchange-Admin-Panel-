<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Services\AddonService;
use Nwidart\Modules\Facades\Module;
use App\Http\Controllers\Controller;

class AddonsController extends Controller
{
    private $service;
    public function __construct()
    {
        $this->service = new AddonService();
    }

    public function addonsSettings()
    {
        try {
            $module = Module::allEnabled();
            $data['settings'] = settings();
            if(!empty($module)){
                // IcoLaunchpad Checked here
                if(isset($module['IcoLaunchpad']))
                $data['IcoLaunchpad'] = true;
                
            }
        } catch (\Exception $e) {
            storeException('addonsSettings', $e->getMessage());
        }
        return view('admin.addons.settings',$data ?? []);
    }

    public function addonsLists()
    {
        try {
            $module = Module::allEnabled();
            $setting = allsetting(['launchpad_settings']);
            $data['list'] = [];
            if(!empty($module)){
                // IcoLaunchpad Checked here
                if(isset($module['IcoLaunchpad']) && $setting['launchpad_settings'] ?? false)
                {
                    $data['list'][] = [
                        'title' => 'IcoLaunchpad',
                        'url' => '/ico-here',
                    ];
                }
                
            }
        } catch (\Exception $e) {
            storeException('addonsLists', $e->getMessage());
        }
        return view('admin.addons.list',$data ?? []);
    }


    public function saveAddonsSettings(Request $request)
    {
        try {
            $response = $this->service->saveAddonSetting($request);
            if ($response['success'] == true) {
                return redirect()->route('addonsSettings')->with('success', $response['message']);
            } else {
                return redirect()->route('addonsSettings')->withInput()->with('success', $response['message']);
            }
        } catch(\Exception $e) {
            storeException('adminCookieSettingsSave',$e->getMessage());
            return redirect()->route('addonsSettings')->with(['dismiss' => $e->getMessage()]);
        }
    }
}
