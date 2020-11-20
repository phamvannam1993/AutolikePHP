<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/27/2018
 * Time: 12:33 AM
 */

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\GiftCode;
use App\Models\GiftCodeUsed;
use App\Request\GiftCodeRequest;
use App\Helpers\ResponseJson;
use App\Models\User;
use App\Helpers\LoginHelper;
use App\Helpers\StringHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GiftCodeController extends Controller
{
    public function __construct()
    {
    }

    public function using()
    {
        return view('website.pages.gift-code.using');
    }
    
    public function applyGiftCode(request $request)
    {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect()->route('admin.login');
        }
        $userId = $checkLogin['userId'];
        $userDetail = User::where('_id', $userId)->first();
        $code = $request->input('code');
        //check code is active
        if(empty($code)) {
            return redirect()->route('website.gift-code.using')
                ->withErrors('Mã gift code không được bỏ trống.')
                ->withInput();
        }

        if(empty($request['g-recaptcha-response'])) {
            return redirect()->route('website.gift-code.using')
                ->withErrors('Bạn cần xác thực google captcha.')
                ->withInput();
        }
        $giftCode = GiftCode::where([
            ['code', $code], ['status' , GiftCode::STATUS_ACTIVE]
        ])->first();

        if (!$giftCode) {
            return redirect()->route('website.gift-code.using')
                ->withErrors('Mã gift code không hợp lệ hoặc đã hết hạn.')
                ->withInput();
        }

        //check user applied this code before
        $giftCodeUsed = GiftCodeUsed::where([
            ['gift_code', $code], ['user_id', $userId]
        ])->first();
        if ($giftCodeUsed) {
            return redirect()->route('website.gift-code.using')
                ->withErrors('Bạn đã sử dụng mã gift code này, vui lòng sử dụng mã khác.')
                ->withInput();
        }

        //check user gift code today
//        $minTodayTime = date('Y-m-d') . ' 00:00:00';
//        $maxTodayTime = date('Y-m-d') . ' 23:59:59';
//        $giftCodeUsedToday = GiftCodeUsed::where([
//            ['created_at', '>=', $minTodayTime], ['created_at', '<=', $maxTodayTime],
//            ['user_id', $userId]
//        ])->first();
//        if ($giftCodeUsedToday) {
//            return redirect()->route('website.gift-code.index')
//                ->withErrors('Một ngày bạn chỉ được sử dụng tối đa 1 mã gift code.')
//                ->withInput();
//        }

        //save gift code
        $giftCode->status = GiftCode::STATUS_USED;
        $giftCode->remaining = 0;
        $giftCode->save();

        //add value to user balance
        $balance = $userDetail['balance'] + $giftCode->value;
        User::where('_id', $userId)->update(['balance' => $balance]);

        //save data to used tabled
        $newGiftCodeUsed = new GiftCodeUsed();
        $newGiftCodeUsed->fill([
            'user_id' => $userId,
            'gift_code_id' => $giftCode->id,
            'gift_code' => $giftCode->code,
            'value' => $giftCode->value
        ]);
        $newGiftCodeUsed->save();
        return redirect()->route('website.gift-code.using')
            ->with(['message' => 'Mã gift hợp lệ. Phần thưởng đã được gửi tới bạn. Xin chân thành cảm ơn.']);
    }

    public function index(Request $request)
    {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        $query = GiftCode::orderBy('_id', 'DESC')->where('user_id', $checkLogin['userId'])->with('user');
        if ($request->input('search') !== null  && $request->input('search') !== '') {
            $query->where('code', 'like', '%' . $request->input('search') . '%');
        }
        $giftCodes = $query->paginate(100);
        $userList = User::get()->toArray();
        $userArr = [];
        if(!empty($userList)) {
            foreach ($userList as $user) {
                $userArr[$user['_id']] = isset($user['fullname']) ? $user['fullname'].' - '.$user['username'] : '';
            }
        }
        return view('website.pages.gift-code.index', compact('giftCodes', 'userArr'));
    }

    public function create(Request $request)
    {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        return view('website.pages.gift-code.create');
    }

    public function history(Request $request)
    {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        if ($request->input('search')) {
            $giftCodeUseds = GiftCodeUsed::orderBy('_id', 'DESC')->where('user_id', $checkLogin['userId'])
                ->where('gift_code', 'like', '%' . $request->input('search') . '%')
                ->with('user')
                ->paginate(100);
        } else {
            $giftCodeUseds = GiftCodeUsed::orderBy('updated_at', 'DESC')->where('user_id', $checkLogin['userId'])
                ->with('user')
                ->paginate(100);
        }
        $userList = User::get()->toArray();
        $userArr = [];
        if(!empty($userList)) {
            foreach ($userList as $user) {
                $userArr[$user['_id']] = isset($user['fullname']) ? $user['fullname'].' - '.$user['username'] : '';
            }
        }
        return view('website.pages.gift-code.history', compact('giftCodeUseds', 'userArr'));
    }

    public function apiUpdateStatus(Request $request)
    {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        try {
            $serviceCode = $request->input('code');
            $serviceStatus = $request->input('status');
            $service = GiftCode::where('code', $serviceCode)->first();
            $service->status = $serviceStatus;
            $service->save();
            return ResponseJson::responseSuccess($service, 'Cập nhật gift code thành công');
        } catch (\Exception $exception) {
            return ResponseJson::systemError($exception);
        }
    }

    public function apiCreate(Request $request)
    {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        try {
            $data = $request->only('number', 'value');
            $giftCodes = [];
            $stringListGiftCode = '';   //get string list gift code to input text field
            $sumMoney = 0;
            for ($i = 0; $i < $data['number']; $i++) {
                $code = StringHelper::generateCode();
                array_push($giftCodes, [
                    'code' => $code,
                    'value' => str_replace(',', '',  $data['value']),
                    'status' => 'Active',
                    'remaining' => 1,
                    'user_id' => $checkLogin['userId'],
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                $sumMoney = $sumMoney + str_replace(',', '',  $data['value']);
                $stringListGiftCode = $stringListGiftCode . $code . "\n";
            }
            $checkUser = User::where('_id', $checkLogin['userId'])->first();
            if($checkUser['balance'] < $sumMoney) {
                return ['code' => 0, 'message' => 'Số tiền của bạn không đủ'];
            } else {
                $balance = $checkUser['balance'] - $sumMoney;
                User::where('_id', $checkLogin['userId'])->update(['balance' => $balance]);
                GiftCode::insert($giftCodes);
                return ResponseJson::responseSuccess($stringListGiftCode, 'Tạo gift code thành công.');
            }
        } catch (\Exception $exception) {
            return ResponseJson::systemError($exception);
        }
    }
}