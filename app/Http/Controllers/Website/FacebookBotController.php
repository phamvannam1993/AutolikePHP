<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/20/2018
 * Time: 9:04 PM
 */

namespace App\Http\Controllers\Website;

use App\Helpers\JavaJobApiHelper;
use App\Http\Controllers\Controller;
use App\Models\FacebookBot;
use App\Models\Service;
use App\Models\ServiceHistory;
use App\Models\ServiceLog;
use App\Models\TokenLog;
use Illuminate\Http\Request;
use App\Helpers\LoginHelper;

class FacebookBotController extends Controller
{
    public function __construct()
    {
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        $logsEvent = TokenLog::orderBy('action_time', 'DESC')->paginate(100);
        return view('website.pages.facebook-bot.index', compact('logsEvent'));
    }

    public function show(Request $request, $uid)
    {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        $token = FacebookBot::where('uid', $uid)->first();
        if (!$token) {
            return view('website.pages.facebook-bot.no-bot');
        }
        $logsEvent = TokenLog::where('uid', $uid)->orderBy('action_time', 'DESC')->paginate(100);
        return view('website.pages.facebook-bot.show', compact('logsEvent', 'token'));
    }

    public function showRedirect(Request $request)
    {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        $uid = $request->input('uid');
        if (!$uid) {
            return redirect()->route('website.fb-bot.index');
        }
        return redirect()->route('website.fb-bot.show', ['uid' => $uid]);
    }
}