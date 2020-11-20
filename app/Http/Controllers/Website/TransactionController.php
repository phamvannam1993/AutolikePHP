<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/19/2018
 * Time: 9:17 AM
 */

namespace App\Http\Controllers\Website;

use App\Helpers\ResponseJson;
use App\Helpers\StringHelper;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Setting;
use App\Request\CreateTransactionRequest;
use Illuminate\Http\Request;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Helpers\LoginHelper;

class TransactionController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect()->route('admin.login');
        }
        $userId = $checkLogin['userId'];
        $transactions = Transaction::where('user_id', $userId)->orderBy('updated_at', 'DESC')->paginate(100);
        return view('website.pages.transaction.index', compact('transactions'));
    }

    public function show(Request $request, $code)
    {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect()->route('admin.login');
        }
        $userId = $checkLogin['userId'];
        $transaction = Transaction::where('code', $code)->first();
        return view('website.pages.transaction.show', compact('transaction'));
    }

    public function apiCreate(CreateTransactionRequest $request)
    {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect()->route('admin.login');
        }
        $userId = $checkLogin['userId'];
        try {
            $packageId = $request->input('plan_id');
            $packageItem = Package::where('_id', $packageId)->first();
            if(!empty($packageItem)) {
                $value = $packageItem->money;
                $bonus = $packageItem->bonus ? $packageItem->bonus*$packageItem->money/100 : 0;
            }

            $transaction = Transaction::create([
                'code' => 'LIKE4' . StringHelper::generateCode(),
                'user_id' => $userId,
                'value' => $value,
                'status' => 'Pending',
                'bonus' => $bonus
            ]);
            return ResponseJson::responseSuccess($transaction, 'Tạo giao dịch thành công.');
        } catch (\Exception $exception) {
            return ResponseJson::systemError($exception);
        }
    }

    public function history($userId) {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        $transactions = Transaction::orderBy('created_at', 'DESC')->where('user_id', $userId)->paginate(100);
        $userList = User::get()->toArray();
        $userArr = [];
        if(!empty($userList)) {
            foreach ($userList as $user) {
                $userArr[$user['_id']] = isset($user['fullname']) ? $user['fullname'].' - '.$user['username'] : '';
            }
        }
        return view('website.pages.transaction.history', ['transactions' => $transactions, 'userArr' => $userArr]);
    }

}