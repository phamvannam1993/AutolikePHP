<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/27/2018
 * Time: 11:32 PM
 */

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Admin;
use App\Helpers\LoginHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request){
        return redirect()->route('admin.login');
    }

    public function list()
    {
        $userList = Admin::paginate(100);
        return view('admin.admin.list', ['userList' => $userList]);
    }

    public function login(request $request){
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if($checkLogin) {
            return redirect()->route('website.home.index');
        }
        $dataLogin = [];
        $messageError = '';
        if($request['email']) {
            $dataLogin['username'] = $request['email'];
            $dataLogin['password'] = md5($request['password']);
            $userLogin = Admin::where('username', $dataLogin['username'])->where('password', $dataLogin['password'])->get()->first();

            if(!empty($userLogin)) {
                $dataLogin['userId'] = $userLogin['_id'];
                session(['dataLogin' => $dataLogin]);
                return redirect()->route('website.home.index');
            } else {
                $messageError = 'Email hoặc mật khẩu không đúng';
            }
        }
        return view('admin.view-login', ['dataLogin' => $dataLogin, 'messageError' => $messageError]);
    }

    public function logout() {
        session(['dataLogin' => '']);
        return redirect(route('admin.login'));
    }

    public function form(request $request) {
        $messageError = '';
        $userDetail = [];
        if(!empty($request['user'])) {
            $user = $request['user'];
            $username =  $user['username'];
            $sffledStr= str_shuffle('abscdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()_-+');
            $uniqueString = md5(time().$sffledStr);
            $userCheck = [];
            if($request['userId'] == 0) {
                $userCheck = Admin::where('username', $username)->get()->toArray();
            }
            if(!empty($userCheck)) {
                $userDetail = $request['user'];
                $messageError = 'Số điện thoại đã tồn tại';
            } else {
                $user['pass_show'] = $user['password'];
                $user['role'] = 2;
                $user['token'] = $uniqueString;
                $user['password'] = md5($user['password']);
                $user['updated_at'] = date('Y-m-d H:i:s');
                $user['created_at'] = date('Y-m-d H:i:s');
                if($request['userId'] > '0') {
                    unset($user['role']);
                    $result = Admin::where('_id', $request['userId'])->update($user);
                } else {
                    $result = Admin::insert($user);
                }
                if($result) {
                    return redirect(route('admin.admin.list'));
                }
            }
        }
        if($request['userId']) {
            $userDetail = Admin::where('_id', $request['userId'])->get()->first();
        }
        $dataList = ['messageError' => $messageError, 'userDetail' => $userDetail];
        return view('admin.admin.form', $dataList);
    }

    public function deleleUser($userId = 0) {
        if($userId > 0) {
            $result = User::where('_id', $userId)->delete();
            if($result > 0) {
                return redirect(route('admin.user.list'));
            }
        }
    }

    public function detail($userId = 0) {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        $userDetail = User::where('_id', $userId)->get()->first();
        return view('admin.user.detail', compact('userDetail'));
    }
}
