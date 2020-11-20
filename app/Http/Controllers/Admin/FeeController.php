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
use App\Models\Fee;
use App\Helpers\LoginHelper;
use Illuminate\Http\Request;

class FeeController extends Controller
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
        $feeList = Fee::orderBy('money', 'ASC')->where('type', 1)->paginate(100);
        $feeItem = Fee::where('type', 2)->first();
        Fee::where('money', '>=', 0)->update(['type' => 1]);
        return view('admin.fee.index', ['feeList' => $feeList, 'feeItem' => $feeItem]);
    }

    public function form(request $request) {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        $feeDetail = [];
        $messageError = '';
        if(!empty($request['fee'])) {
            $fee = $request['fee'];
            $fee['money'] = (int)$fee['money'];
            $fee['type'] = 1;
            $fee['updated_at'] = date('Y-m-d H:i:s');
            $fee['created_at'] = date('Y-m-d H:i:s');

            if($request['feeId'] && $request['feeId'] > 0) {
                $result = Fee::where('_id', $request['feeId'])->update($fee);
            } else {
                $result = Fee::insert($fee);
            }
            if($result) {
                return redirect(route('admin.fee.list'));
            }
        }
        if($request['feeId']) {
            $feeDetail = Fee::where('_id', $request['feeId'])->first();
        }
        $dataList = ['messageError' => $messageError, 'feeDetail' => $feeDetail];
        return view('admin.fee.form', $dataList);
    }

    public function updateFee(Request $request) {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        $bonus = $request['bonus'];
        if($bonus > 0) {
            Fee::where('type', 2)->update(['bonus' => $bonus]);
        }
    }

    public function deleleFee($feeId = 0) {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        if($feeId > 0) {
           $result = Fee::where('_id', $feeId)->delete();
           if($result > 0) {
               return redirect(route('admin.fee.list'));
           }
        }
    }

}
