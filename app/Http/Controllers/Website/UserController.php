<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/22/2018
 * Time: 01:19 AM
 */

namespace App\Http\Controllers\Website;

use App\Helpers\ResponseJson;
use App\Helpers\StringHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\LoginHelper;

class UserController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        $users = User::whereNull('invite_code')->orderBy('updated_at', 'DESC')->paginate(100);
        return view('website.pages.user.index', compact('users'));
    }

    public function history($UserId) {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        $users = User::where('referrer_user_id', $UserId)->orderBy('updated_at', 'DESC')->paginate(100);
        return view('website.pages.user.history', compact('users'));
    }

    public function agency() {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        $users = User::whereNotNull('invite_code')->orderBy('updated_at', 'DESC')->paginate(100);
        //User::whereNotNull('invite_code')->update(['agency_status' => '2']);
        return view('website.pages.user.agency', compact('users'));
    }

    public function apiUpdateStatus(Request $request)
    {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        try {
            $userId = $request->input('id');
            $userStatus = $request->input('status');
            User::where('_id', $userId)->update(['status' => $userStatus]);
            $user = User::where('_id', $userId)->first();
            return ResponseJson::responseSuccess($user, 'Cập nhật trạng thái thành viên');
        } catch (\Exception $exception) {
            return ResponseJson::systemError($exception);
        }
    }

    public function updateRole(Request $request) {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        try {
            $userId = $request->input('id');
            $userStatus = $request->input('status');
            User::where('_id', $userId)->update(['agency_status' => $userStatus]);
            $user = User::where('_id', $userId)->first();
            return ResponseJson::responseSuccess($user, 'Cập nhật trạng thái thành viên');
        } catch (\Exception $exception) {
            return ResponseJson::systemError($exception);
        }
    }
}