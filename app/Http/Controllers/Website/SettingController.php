<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/22/2018
 * Time: 2:56 PM
 */

namespace App\Http\Controllers\Website;

use App\Helpers\JavaJobApiHelper;
use App\Helpers\ResponseJson;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\LoginHelper;

class SettingController extends Controller
{
    public function __construct()
    {
    }

    public function edit()
    {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        $settings = Setting::all()->keyBy('key');
        return view('website.pages.setting.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        try {
            $allData = $request->all();
            foreach ($allData as $key => $value) {
                //update setting
                Setting::where('key', $key)->update(['value' => $value]);
            }
            $settings = Setting::all()->keyBy('key');
            $pushSetting = $request->only(
                'viplike_like_per_day', 'viplike_post_per_day',
                'time_cycle_use_token', 'number_like_token_use_per_time', 'time_between_2times_like', 'time_feed_scan'
            );
            //push data to java job
            $putServiceToJavaJobRes = JavaJobApiHelper::requestApi(
                env('JAVA_JOB_API_URL') . '/fblike4vip/config',
                'POST',
                $pushSetting
            );
            if (!$putServiceToJavaJobRes['success']) {
                //return ResponseJson::responseError([], $putServiceToJavaJobRes['msg']);
            }
            return ResponseJson::responseSuccess($settings, 'Cập nhật thành công');
        } catch (\Exception $exception) {
            return ResponseJson::systemError($exception);
        }

    }
}