<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/18/2018
 * Time: 11:35 PM
 */

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Request\LoginRequest;
use App\Request\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $userModel;
    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function login()
    {
        return view('website.pages.auth.login');
    }

    public function register(Request $request)
    {
        $referrerCode = $request->input('referrer_code');
        return view('website.pages.auth.register', compact('referrerCode'));
    }

    public function doLogin(LoginRequest $request)
    {
        try {
            $params = [
                'phone' => $request->input('phone'),
                'password' => $request->input('password')
            ];
            if (!$params['phone'] || !$params['password']) {
                return false;
            }
            $user = $this->userModel->checkLogin($params);
            if (!$user) {
                return redirect()->route('website.auth.login')
                    ->withErrors(trans('auth.login_fail'))
                    ->withInput();
            }

            if ($user->status == User::STATUS_BLOCK) {
                return redirect()->route('website.auth.login')
                    ->withErrors(trans('auth.blocked'))
                    ->withInput();
            }

            $user->last_time_login = date('Y-m-d H:i:s');
            $user->save();
            Auth::login($user);
            return redirect()->route('website.home.index');
        } catch (\Exception $exception) {
            return redirect()->route('website.auth.login')
                ->withErrors(trans('common.have_problem_try_again'))
                ->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('website.auth.login');
    }

    public function doRegister(RegisterRequest $request)
    {
        try {
            $user = new User();
            $user->password = Hash::make($request->input('password'));
            $user->name = $request->name;
            $user->phone = $request->phone;

            //check phone number
            if (!$this->checkPhoneNumber($request->phone)) {
                return redirect()->route('website.auth.register')
                    ->withErrors('Định dang số điện thoại không chính xác.')
                    ->withInput();
            }

            //check phone number exist
            $findUser = User::where('phone', $request->phone)->first();
            if ($findUser) {
                return redirect()->route('website.auth.register')
                    ->withErrors('Số điện thoại đã được sử dụng để đăng kí, xin vui lòng nhập số khác.')
                    ->withInput();
            }

            if ($request->input('referrer_code')) {
                //get referrer user
                $referrer = User::where('invite_code', $request->input('referrer_code'))->first();
                $user->referrer_code = $referrer->invite_code;
                $user->referrer_user_id = $referrer->id;
            }
            $user->last_time_login = date('Y-m-d H:i:s');
            $user->save();
            Auth::login($user, true);
            return redirect()->route('website.home.index');
        } catch (\Exception $exception) {
            return redirect()->route('website.auth.register')
                ->withErrors(trans('common.have_problem_try_again'))
                ->withInput();
        }
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