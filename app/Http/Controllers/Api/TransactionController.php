<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/19/2018
 * Time: 9:17 AM
 */

namespace App\Http\Controllers\Website;

use App\Components\TransactionComponent;
use App\Helpers\ResponseJson;
use App\Helpers\StringHelper;
use App\Http\Controllers\Controller;
use App\Models\SmsLog;
use App\Models\Transaction;

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

    public function apiApprove(Request $request)
    {
        try {
            $transactionCode = $request->input('code');
            $transaction = Transaction::where('code', $transactionCode)->with('user')->first();
            if (!$transaction) {
                return ResponseJson::responseError([], 'Không tìm thấy giao dịch');
            }

            if ($transaction->status == Transaction::STATUS_COMPLETED) {
                return ResponseJson::responseError($transaction, 'Giao dịch đã được phê duyệt từ trước, vì thế sẽ không công thêm số dư vào tài khoản 1 lần nữa.');
            }

            $transaction = $this->transactionComponent->handleApproveTransaction($transaction);
            return ResponseJson::responseSuccess(
                $transaction,
                'Phê duyệt thành công. Số dư đã được cộng thêm vào tài khoản của ' . $transaction->user->name . '-' . $transaction->user->phone
            );
        } catch (\Exception $exception) {
            return ResponseJson::systemError($exception);
        }
    }


}