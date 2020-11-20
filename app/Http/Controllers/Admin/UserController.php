<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/27/2018
 * Time: 11:32 PM
 */

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseJson;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Device;
use App\Models\GroupProfile;
use App\Models\ActionProfile;
use Illuminate\Http\Request;
use App\Helpers\LoginHelper;

class UserController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $userList = User::where('role', 2)->paginate(100);
        return view('admin.user.list', ['userList' => $userList]);
    }

    public function addUser(request $request)
    {
        if(!empty($request['username']) && !empty($request['password'])) {
            $user= User::where('username', $request['username'])->get()->toArray();
            if(!empty($user)) {
                return 'Username available';
            } else {
                $dataUser = [
                    'username' => $request['username'],
                    'password' => md5($request['password'])
                ];
                $result = User::insert($dataUser);
                return 'Success';
            }
        }
    }

    public function form(request $request) {
        $messageError = '';
        $userDetail = [];
        if(!empty($request['user'])) {
            $user = $request['user'];
            $username =  $user['username'];
            $sffledStr= str_shuffle('abscdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()_-+');
            $uniqueString = md5(time().$sffledStr);
            $messageError = $this->getMessageError($username, $request);
            $userDetail = $request['user'];
            if(empty($messageError)) {
                $user['pass_show'] = $user['password'];
                $user['balance_use'] = 0;
                $user['balance'] = 0;
                $user['deposit_amount'] = 0;
                $user['password'] = md5($user['password']);
                $user['updated_at'] = date('Y-m-d H:i:s');
                $user['created_at'] = date('Y-m-d H:i:s');
                $user['status'] = User::STATUS_ACTIVE;
                $user['token'] = $uniqueString;
                if ($request['referrer_code']) {
                    $referrer = User::where('invite_code', $request->input('referrer_code'))->first();
                    $user['referrer_code'] = $referrer->invite_code;
                    $user['referrer_user_id'] = $referrer->id;
                }
                $result = User::create($user);
                $dataLogin = $result;
                if($result) {
                    $dataLogin['userId'] = $result['_id'];
                    session(['dataLogin' => $dataLogin]);
                    return redirect()->route('website.home.index');
                }
            }
        }
        if($request['userId']) {
           $userDetail = User::where('_id', $request['userId'])->get()->first();
        }
        $dataList = ['messageError' => $messageError, 'userDetail' => $userDetail];
        return view('admin.user.form', $dataList);
    }

    function getMessageError($username, $request) {
        $userCheck = User::where('username', $username)->get()->toArray();
        $messageError = '';
        if(empty($request['g-recaptcha-response'])) {
            $messageError = 'Bạn cần xác thực google captcha';
        }
        if(!empty($userCheck)) {
            $messageError = 'Số điện thoại đã tồn tại';
        }
        if (!$this->checkPhoneNumber($username)) {
            $messageError = 'Định dang số điện thoại không chính xác.';
        }
        if ($request['referrer_code']) {
            $referrer = User::where('invite_code', $request->input('referrer_code'))->first();
            if(empty($referrer)) {
                $messageError = 'Mã giới thiệu chưa chính xác.';
            }
        } else {
            $messageError = 'Vui lòng nhập mã giới thiệu.';
        }
        return $messageError;
    }

    public function deleleUser($userId = 0) {
        if($userId > 0) {
           $result = User::where('_id', $userId)->delete();
           if($result > 0) {
               return redirect(route('admin.user.list')); 
           }
        }
    }

    public function changPassword(request $request) {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        $code = 1;
        $message = '';
        if($request['user']) {
            $requestUser = $request['user'];
            $checkUser = User::where('_id', $checkLogin['userId'])->where('password', md5($requestUser['password']))->first();
            if(!empty($checkUser)) {
                $password = md5($requestUser['password_new']);
                if($requestUser['password_new'] == $requestUser['password_confirm']) {
                    User::where('_id', $checkLogin['userId'])->update(['password' => $password]);
                    $message = 'Thay đổi mật khẩu thành công';
                    $request['user'] = [];
                } else {
                    $message = 'Mật khẩu mới và mật khẩu xác nhận không trùng nhau';
                    $code = 0;
                }
            } else {
                $message = 'Sai mật khẩu';
                $code = 0;
            }
        }
        $user = $request['user'] ? $request['user'] : [];
        return view('admin.user.change_pass', ['user' => $user, 'code' => $code, 'message' => $message]);
    }

    private function checkPhoneNumber($string)
    {
        // Allow +, - and . in phone number
        $filtered_phone_number = filter_var($string, FILTER_SANITIZE_NUMBER_INT);
        // Remove "-" from number
        $phone_to_check = str_replace("-", "", $filtered_phone_number);
        // Check the lenght of number
        // This can be customized if you want phone number from a specific country
        if (strlen($phone_to_check) < 10 || strlen($phone_to_check) > 14) {
            return false;
        } else {
            return true;
        }
    }
}
