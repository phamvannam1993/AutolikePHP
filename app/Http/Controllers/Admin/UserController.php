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
use App\Helpers\StringHelper;

class UserController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $userList = User::where('role', 2)->paginate(100);
        $actionArr = [];
        return view('admin.user.list', ['userList' => $userList, 'actionArr' => $actionArr]);
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
            $userCheck = User::where('username', $username)->get()->toArray();
            if (!$this->checkPhoneNumber($username)) {
                $messageError = 'Định dang số điện thoại không chính xác.';
            } else if(!empty($userCheck)) {
                $messageError = 'Số điện thoại đã tồn tại';
            } else {
                $user['pass_show'] = $user['password'];
                $user['invite_code']  = StringHelper::generateCode();
                $user['agency_status'] = '2';
                $user['password'] = md5($user['password']);
                $user['updated_at'] = date('Y-m-d H:i:s');
                $user['created_at'] = date('Y-m-d H:i:s');
                $user['status'] = \App\Models\User::STATUS_ACTIVE;
                $user['token'] = $uniqueString;
                $result = User::create($user);
                if($result) {
                    return redirect(route('website.user.index'));
                }
            }
            $userDetail = $user;
        }
        $dataList = ['messageError' => $messageError];
        return view('admin.user.form', $dataList);
    }

    public function save(request $request) {
        if(!empty($request['user'])) {
            $user = $request['user'];
            $user['pass_show'] = $user['password'];
            $user['balance'] = $user['balance'];
            $user['password'] = md5($user['password']);
            $user['updated_at'] = date('Y-m-d H:i:s');
            if($user['userId'] == 0) {
                unset($user['userId']);
                $user['created_at'] = date('Y-m-d H:i:s');
                $result = User::insert($user);
            } else {
                $userId = $user['userId'];
                unset($user['userId']);
                $result = User::where('_id', $userId)->update($user);
            }
            
            if($result) {
                return redirect(route('admin.user.list'));
            }
        }
    }

    public function deleleUser($userId = 0) {
        if($userId > 0) {
           $result = User::where('_id', $userId)->delete();
           if($result > 0) {
               return redirect(route('admin.user.list')); 
           }
        }
    }

    function device(request $request) {
        $userId = $request['uid'];
        $groupArr = [];
        $actionArr = [];
        $groupList = GroupProfile::where('user_id', $userId)->get()->toArray();
        $actionProfile = ActionProfile::get()->toArray();
        if(!empty($groupList)) {
            foreach ($groupList as $group) {
                $groupArr[$group['_id']] = $group['name'];
            }
        }

        if(!empty($actionProfile)) {
            foreach ($actionProfile as $action) {
                $actionArr[$action['_id']] = $action['name'];
            }
        }
        $deviceList = Device::where('user_id', $userId)->paginate(100);
        return view('admin.user.ajax_view_device', ['deviceList' => $deviceList, 'groupArr' => $groupArr, 'actionArr' => $actionArr ]);
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

    public function profile() {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        $userId = $checkLogin['userId'];
        $userDetail = User::where('_id', $userId)->get()->toArray();
        return view('admin.view-profile', compact('userDetail'));
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
