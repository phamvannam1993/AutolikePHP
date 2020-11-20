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
use App\Helpers\LoginHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class AdminController extends Controller
{
    public function index(Request $request){
        return redirect()->route('admin.login');
    }

    public function login(request $request){
         $LoginHelper = new LoginHelper();
         $checkLogin = $LoginHelper->checkSession();
         if($checkLogin) {
            return redirect()->route('website.home.index');
         }
        $dataLogin = [];
        $messageError = '';
        if($request['username']) {
            $dataLogin['username'] = $request['username'];
            $dataLogin['password'] = md5($request['password']);
            $userLogin = User::where('username', $dataLogin['username'])->where('password', $dataLogin['password'])->get()->first();
            if(!empty($userLogin)) {
                if($userLogin['status'] != \App\Models\User::STATUS_ACTIVE) {
                    $messageError = 'Tài khoản của bạn tạm thời bị khóa';
                } else {
                    User::where('username', $dataLogin['username'])->where('password', $dataLogin['password'])->update(['last_time_login' => date('Y/m/d H:i:s')]);
                    $dataLogin = $userLogin;
                    $dataLogin['userId'] = $userLogin['_id'];
                    $dataLogin['invite_code'] = isset($userLogin['invite_code']) ? $userLogin['_id'] : '';
                    session(['dataLogin' => $dataLogin]);
                    return redirect()->route('website.home.index');
                }
            } else {
                $messageError = 'Tên tài khoản hoặc mật khẩu không đúng';
            }
        }
        return view('admin.view-login', ['dataLogin' => $dataLogin, 'messageError' => $messageError]);
    }

    public function logout() {
        session(['dataLogin' => '']);
        return redirect(route('admin.login'));
    }

    public function sendMSM(request $request) {
        $number = $request['PhoneNumber'];
        $check = User::where('username', $number)->get()->first();

        if(empty($check)) {
            return json_encode(['code' => 0, 'message' => 'Phone number does not exist.']);
        } else {
            if(isset($check['updated_last_date']) && $check['updated_last_date'] >= date('Y-m-d')) {
                return json_encode(['code' => 0, 'message' =>'You are only allowed to send once a day.']);
            }
            User::where('username', $number)->update(['updated_last_date' => date('Y-m-d')]);
            $account_sid = 'ACaf9aa0895dc53c2f690028bce0347b93';
            $auth_token = 'bfb9574682f9bce4f7b0b4f335560c5a';
            $twilio_number = "+14702910256";
            $phoneNumber = (int)$number;
            $client = new Client($account_sid, $auth_token);
            $client->messages->create(
            // Where to send a text message (your cell phone?)
                '+84'.$phoneNumber,
                array(
                    'from' => $twilio_number,
                    'body' => __('Your password is') .' '.$check['pass_show'],
                )
            );
            return json_encode(['code' => 1, 'message' => 'Send Password Success.']);
        }
    }

}
