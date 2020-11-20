<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/19/2018
 * Time: 6:37 AM
 */

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Helpers\LoginHelper;
use Pusher\Pusher;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Service;

class HomeController extends Controller
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
        $number_user = User::count();
        $number_transaction = Transaction::where('status', Transaction::STATUS_COMPLETED)->count();
        $number_service = Service::where('status', Service::STATUS_ACTIVE)->count();
        $total_transaction_value = Transaction::where('status', Transaction::STATUS_COMPLETED)->sum('value');
        return view('website.pages.dashboard.home', ['userDetail' => $checkLogin, 'number_user' => $number_user, 'number_service' => $number_service, 'number_transaction' => $number_transaction, 'total_transaction_value' => $total_transaction_value]);
    }
}