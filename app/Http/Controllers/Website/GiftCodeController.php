<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/26/2018
 * Time: 11:25 PM
 */

namespace App\Http\Controllers\Website;

use App\Helpers\ResponseJson;
use App\Helpers\StringHelper;
use App\Http\Controllers\Controller;
use App\Models\GiftCode;
use App\Models\User;
use App\Models\GiftCodeUsed;
use Illuminate\Http\Request;
use App\Helpers\LoginHelper;

class GiftCodeController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request)
    {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        $query = GiftCode::orderBy('_id', 'DESC')->with('user');
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
            $giftCodeUseds = GiftCodeUsed::orderBy('_id', 'DESC')
                ->where('gift_code', 'like', '%' . $request->input('search') . '%')
                ->with('user')
                ->paginate(100);
        } else {
            $giftCodeUseds = GiftCodeUsed::orderBy('updated_at', 'DESC')
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
            for ($i = 0; $i < $data['number']; $i++) {
                $code = StringHelper::generateCode();
                array_push($giftCodes, [
                    'code' => $code,
                    'value' => str_replace(',', '',  $data['value']),
                    'status' => 'Active',
                    'remaining' => 1,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                $stringListGiftCode = $stringListGiftCode . $code . "\n";
            }
            $insert = GiftCode::insert($giftCodes);
            return ResponseJson::responseSuccess($stringListGiftCode, 'Tạo gift code thành công.');
        } catch (\Exception $exception) {
            return ResponseJson::systemError($exception);
        }
    }
}