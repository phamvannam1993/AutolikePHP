<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/19/2018
 * Time: 6:37 AM
 */

namespace App\Http\Controllers\Website;

use App\Models\Setting;
use App\Http\Controllers\Controller;
use App\Singleton\SettingSingleton;
use App\Models\User;
use App\Models\Package;
use App\Helpers\LoginHelper;

class HomeController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect()->route('admin.login');
        }
		$setting = Setting::all()->keyBy('key');
        $result = User::where('_id', $checkLogin['userId'])->first();
        $dataLogin = $result;
        $dataLogin['userId'] = $result['_id'];
        session(['dataLogin' => $dataLogin]);
        $settingsSingleton = new SettingSingleton();
        $settings = $settingsSingleton->getSetting();
		$likePage =  $setting['like_page']->value;
		$addfriend = $setting['sub_follow']->value;
		$type = 0;
		$packageList = Package::orderBy('money', 'ASC')->get()->toArray();
        return view('website.pages.dashboard.home', compact('type', 'settings', 'likePage', 'addfriend', 'packageList'));
    }

    public function money() {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect()->route('admin.login');
        }
        $setting = Setting::all()->keyBy('key');
        $result = User::where('_id', $checkLogin['userId'])->first();
        $dataLogin = $result;
        $dataLogin['userId'] = $result['_id'];
        session(['dataLogin' => $dataLogin]);
        $settingsSingleton = new SettingSingleton();
        $settings = $settingsSingleton->getSetting();
        $likePage =  $setting['like_page']->value;
        $addfriend = $setting['sub_follow']->value;
        $type = 1;
        $packageList = Package::orderBy('money', 'ASC')->get()->toArray();
        return view('website.pages.dashboard.home', compact('type', 'settings', 'likePage', 'addfriend', 'packageList'));
    }

    public function buyService() {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect()->route('admin.login');
        }
        $setting = Setting::all()->keyBy('key');
        $result = User::where('_id', $checkLogin['userId'])->first();
        $dataLogin = $result;
        $dataLogin['userId'] = $result['_id'];
        session(['dataLogin' => $dataLogin]);
        $settingsSingleton = new SettingSingleton();
        $settings = $settingsSingleton->getSetting();
        $likePage =  $setting['like_page']->value;
        $addfriend = $setting['sub_follow']->value;
        $type = 2;
        $packageList = Package::orderBy('money', 'ASC')->get()->toArray();
        return view('website.pages.dashboard.home', compact('type', 'settings', 'likePage', 'addfriend', 'packageList'));
    }
}