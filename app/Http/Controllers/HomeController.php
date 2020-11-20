<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/27/2018
 * Time: 11:32 PM
 */

namespace App\Http\Controllers;
use App\Singleton\SettingSingleton;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Package;
use App\Helpers\LoginHelper;
use App\Helpers\ResponseJson;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
    }

    public function index()
    {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        $settingsSingleton = new SettingSingleton();
        $settings = $settingsSingleton->getSetting();
        $packageList = Package::get()->toArray();
        return view('website.pages.dashboard.home', compact('settings', 'packageList'));
    }

    public function changeLanguage($language)
    {
        \Session::put('website_language', $language);
        return redirect()->back();
    }
}