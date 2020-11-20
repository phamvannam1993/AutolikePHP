<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/19/2018
 * Time: 9:17 AM
 */

namespace App\Http\Controllers\Admin;

use App\Components\TransactionComponent;
use App\Helpers\ResponseJson;
use App\Helpers\StringHelper;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Fee;
use App\Request\CreateTransactionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\LoginHelper;

class TransactionController extends Controller
{
    protected $transactionComponent;
    public function __construct(TransactionComponent $transactionComponent)
    {
        $this->transactionComponent = $transactionComponent;
    }

    public function index()
    {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        $transactions = Transaction::orderBy('created_at', 'DESC')->with('user')->paginate(100);
        $userList = User::get()->toArray();
        $userArr = [];
        if(!empty($userList)) {
            foreach ($userList as $user) {
                $userArr[$user['_id']] = isset($user['fullname']) ? $user['fullname'].' - '.$user['username'] : '';
            }
        }
        return view('website.pages.transaction.index', ['transactions' => $transactions, 'userArr' => $userArr]);
    }

    public function tranList()
    {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        $transactions = Transaction::orderBy('created_at', 'DESC')->with('user')->paginate(100);
        $userList = User::get()->toArray();
        $userArr = [];
        if(!empty($userList)) {
            foreach ($userList as $user) {
                $userArr[$user['_id']] = isset($user['fullname']) ? $user['fullname'].' - '.$user['username'] : '';
            }
        }
        return view('website.pages.transaction.index', ['transactions' => $transactions, 'userArr' => $userArr]);
    }

    public function history($userId) {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        $transactions = Transaction::orderBy('created_at', 'DESC')->where('user_id', $userId)->with('user')->paginate(100);
        $userList = User::get()->toArray();
        $userArr = [];
        if(!empty($userList)) {
            foreach ($userList as $user) {
                $userArr[$user['_id']] = isset($user['fullname']) ? $user['fullname'].' - '.$user['username'] : '';
            }
        }
        return view('website.pages.transaction.history', ['transactions' => $transactions, 'userArr' => $userArr]);
    }

    public function show($code)
    {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        $transaction = Transaction::where('code', $code)->first();
        $userList = User::get()->toArray();
        $userArr = [];
        if(!empty($userList)) {
            foreach ($userList as $user) {
                $userArr[$user['_id']] = isset($user['fullname']) ? $user['fullname'].' - '.$user['username'] : '';
            }
        }
        return view('website.pages.transaction.show', ['transaction' => $transaction, 'userArr' => $userArr]);
    }

    public function apiCreate(CreateTransactionRequest $request)
    {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        try {
            $planId = $request->input('plan_id');
            if (!in_array($planId, [100, 200, 500, 1000, 2000, 3000, 5000, 10000])) {
                return ResponseJson::responseError(null, 'Gói nạp tiền không chính xác.');
            }
            $value = $planId * 1000;
            $transaction = Transaction::create([
                'code' => StringHelper::generateCode(),
                'user_id' => Auth::user()->id,
                'value' => $value,
                'status' => 'Pending'
            ]);
            return ResponseJson::responseSuccess($transaction, 'Tạo giao dịch thành công.');
        } catch (\Exception $exception) {
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
            $transactionCode = $request->input('code');
            $transactionStatus = $request->input('status');
            $transaction = Transaction::where('code', $transactionCode)->with('user')->first();
            $userId = $transaction->user_id;
            if ($transactionStatus == Transaction::STATUS_COMPLETED && $transaction->status != Transaction::STATUS_COMPLETED) {
                $dataTransaction = [
                    'accepted_by' => null,
                    'completed_at' => date('Y-m-d H:i:s'),
                    'status' =>  Transaction::STATUS_COMPLETED
                ];
                Transaction::where('code', $transactionCode)->update($dataTransaction);
                $userDetail = User::where('_id', $userId)->first();
                $balance = $userDetail['balance'] + ($transaction->value + $transaction->bonus);
                $deposit_amount = $userDetail['deposit_amount'] + ($transaction->value + $transaction->bonus);
                $balance_use = isset($userDetail['balance_use']) ? (int)$userDetail['balance_use'] : 0;
                $feeDetail = Fee::where('money','<=', $balance_use)->orderBy('money', 'ASC')->first();
                $day = (int)date('d');
                if(!empty($feeDetail) && in_array($day, [5,10,15,20,25,30])) {
                   // $this->updateBalance($feeDetail, $userDetail, $balance_use);
                }
                User::where('_id', $userId)->update(['balance' => (int)$balance, 'deposit_amount' => (int)$deposit_amount]);
                $transaction = Transaction::where('code', $transactionCode)->with('user')->first();
                return ResponseJson::responseSuccess(
                    $transaction,
                    'Phê duyệt thành công. Số dư đã được cộng thêm vào tài khoản của ' . $userDetail->fullname . '-' . $userDetail->username
                );
            }
            return ResponseJson::responseSuccess($transaction, 'Cập nhật dịch vụ thành công');
        } catch (\Exception $exception) {
            return ResponseJson::systemError($exception);
        }
    }

    function updateBalance($feeDetail, $userDetail, $balance_use) {
        $bonus = $feeDetail['bonus'];
        $balance = $balance_use*$bonus/100;
        $referrer_user_id = isset($userDetail['referrer_user_id']) ? $userDetail['referrer_user_id'] : 0;
        $userReDetail = User::where('_id', $referrer_user_id)->first();
        if(!empty($userReDetail)) {
            $balance = $balance + $userReDetail['balance'];
            User::where('_id', $referrer_user_id)->update(['balance' => $balance]);
        }
    }
}