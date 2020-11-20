<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/18/2018
 * Time: 11:35 PM
 */

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Manager;
use App\Request\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $managerModel;
    public function __construct(Manager $managerModel)
    {
        $this->managerModel = $managerModel;
    }

    public function login()
    {
        return view('website.pages.auth.login');
    }

    public function doLogin(LoginRequest $request)
    {
        try{
            $params = [
                'phone' => $request->input('phone'),
                'password' => $request->input('password')
            ];
            if (!$params['phone'] || !$params['password']) {
                return false;
            }
            $manager = $this->managerModel->checkLogin($params);
            if (!$manager) {
                return redirect()->route('website.auth.login')
                    ->withErrors(trans('auth.login_fail'))
                    ->withInput();
            }
            Auth::login($manager);
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
}