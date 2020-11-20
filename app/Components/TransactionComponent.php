<?php

/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/26/2018
 * Time: 12:17 AM
 */

namespace App\Components;

use App\Helpers\PusherHelper;
use App\Helpers\ResponseJson;
use App\Models\Transaction;

class TransactionComponent
{
    protected $pusherHelper;
    public function __construct(PusherHelper $pusherHelper)
    {
        $this->pusherHelper = $pusherHelper;
    }

    public function handleApproveTransaction($transaction)
    {
        $transaction->status = Transaction::STATUS_COMPLETED;
        $transaction->accepted_by = null;
        $transaction->completed_at = date('Y-m-d H:i:s');
        $transaction->save();

        $transaction->user->balance += ($transaction->value + $transaction->bonus);
        $transaction->user->save();

        //push notify through pusher
        $this->pushNotifyForUser($transaction->user, $transaction);
        return $transaction;
    }

    private function pushNotifyForUser($user, $transaction)
    {
        return $this->pusherHelper->pushNotify(
            md5($user->_id . '-' . $user->created_at),
            'update-transaction-status',
            [
                'success' => 1,
                'message' => 'Thanh toán thành công',
                'transaction_status' => $transaction->status
            ]
        );
    }
}