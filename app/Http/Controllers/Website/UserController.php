<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/29/2018
 * Time: 10:47 PM
 */

namespace App\Http\Controllers\Website;
use App\Models\User;
use App\Helpers\ResponseJson;
use App\Helpers\StringHelper;
use App\Http\Controllers\Controller;
use App\Request\UpdateProfileRequest;
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
        $users = User::where('referrer_user_id', $checkLogin['userId'])->orderBy('updated_at', 'DESC')->paginate(100);
        return view('website.pages.user.index', compact('users'));
    }

    public function profile()
    {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect()->route('admin.login');
        }
        $userId = $checkLogin['userId'];
        $requester = User::where('_id', $userId)->first();
        $referrer_user_id = isset($requester['referrer_user_id']) ? $requester['referrer_user_id'] : 0;
        $userReferDetail = User::where('_id', $referrer_user_id)->first();
        return view('website.pages.user.profile', compact('requester', 'userReferDetail'));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            $profileData = $request->only('fullname', 'bank_name', 'bank_account_name', 'bank_account_number');
            $LoginHelper = new LoginHelper();
            $checkLogin = $LoginHelper->checkSession();
            if(!$checkLogin) {
                return redirect()->route('admin.login');
            }
            $userId = $checkLogin['userId'];
            User::where('_id', $userId)->update($profileData);
            $dataLogin = User::where('_id', $userId)->first();
            $dataLogin['userId'] =$userId;
            session(['dataLogin' => $dataLogin]);
            return ResponseJson::responseSuccess([], 'Cập nhật thành công');
        }  catch (\Exception $exception) {
            return ResponseJson::systemError($exception);
        }
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
}