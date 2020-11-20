<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/20/2018
 * Time: 9:04 PM
 */

namespace App\Http\Controllers\Website;

use App\Helpers\JavaJobApiHelper;
use App\Helpers\ResponseJson;
use App\Helpers\StringHelper;
use App\Http\Controllers\Controller;
use App\Models\Logs;
use App\Models\Service;
use App\Models\Fee;
use App\Models\ServiceLog;
use App\Models\ScanPost;
use App\Models\Setting;
use App\Models\LogConfig;
use App\Singleton\SettingSingleton;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Helpers\LoginHelper;
use App\Models\User;


class ServiceController extends Controller
{
    public function __construct()
    {
    }

    public function viplikeList(Request $request) {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect()->route('admin.login');
        }
        $userId = $checkLogin['userId'];
        $services = Service::where('type', Service::TYPE_VIPLIKE)->where('user_id', $userId)->orderBy('_id', 'DESC')->paginate(100);
        return view('website.pages.service.list', compact('services'));
    }

    public function index(Request $request)
    {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect()->route('admin.login');
        }
        $userId = $checkLogin['userId'];
        $status = $request->input('status');
        $date = !empty($request->input('date')) ? $request->input('date') : date('Y-m-d');
        if ($date == date('Y-m-d')) {
            if ($status) {
                $services = Service::where('user_id', $userId)
                    ->where('type', Service::TYPE_VIPLIKE)
                    ->orderBy('created_at', 'DESC')
                    ->where('status', $status)
                    ->paginate(100);

            } else {
                $services = Service::where('user_id', $userId)
                    ->where('type', Service::TYPE_VIPLIKE)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(100);
            }
        } else if ($date < date('Y-m-d')) {
            $listServiceHistory = ServiceLog::where([
                ['date', $date]
            ])->get();
            $listServiceCode = $listServiceHistory->pluck('service_code')->toArray();
            $services = Service::whereIn('code', $listServiceCode)->where('type', Service::TYPE_VIPLIKE)->where('user_id', $userId)->orderBy('_id', 'DESC')->paginate(100);
        } else {
            return view('website.pages.service.no-service');
        }
        $dataLogService = [];
        $dataService = [];
        if(!empty($services)) {
            foreach ($services as $service) {
                $serviceLog = ServiceLog::where('service_code', $service['code'])->where('date', $date)->first();
                if(!empty($serviceLog)) {
                    $ListScanPost = ScanPost::where('log_id', $serviceLog['_id'])->where('status', 'live')->get()->toArray();
                    $dataService[$service['code']]['number_like_per_post'] = $serviceLog['number_like_per_post'];
                    $dataService[$service['code']]['status'] = $serviceLog['status'];
                    $dataService[$service['code']]['created_at'] = date('Y/m/d H:i:s', strtotime($serviceLog['created_at']));
                    $dataService[$service['code']]['updated_at'] = date('Y/m/d H:i:s', strtotime($serviceLog['updated_at']));
                    $dataService[$service['code']]['date_time'] = date('Y/m/d H:i:s', strtotime($serviceLog['updated_at']));
                    $dataService[$service['code']]['number_post'] = count($ListScanPost);
                    if(!empty($ListScanPost)) {
                        foreach ($ListScanPost as $scanPost) {
                            $postId = explode('_', $scanPost['id']);
                            $scanPost['link_post'] = isset($postId[1]) ? 'https://www.facebook.com/'.$postId[1] : '';
                            $scanPost['created_at'] = isset($scanPost['created_at']) ? date('Y/m/d H:i:s', strtotime($scanPost['created_at'])) : '';
                            $scanPost['updated_at'] = isset($scanPost['updated_at']) ? date('Y/m/d H:i:s', strtotime($scanPost['updated_at'])) : '';
                            $dataLogService[$service['code']][] = $scanPost;
                        }
                    }
                }
            }
        }
        if ($date < date('Y-m-d')) {
            return view('website.pages.service.history', compact('services', 'dataLogService', 'date', 'dataService'));
        }

        return view('website.pages.service.index', compact('services', 'dataLogService', 'date'));
    }

    public function history(Request $request) {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect()->route('admin.login');
        }
        $userId = $checkLogin['userId'];
        $userIds = [];
        $serviceIds = [];
        $dataUser = [];
        $date = !empty($request->input('date')) ? $request->input('date') : date('Y-m-d');
        $userList = User::where('referrer_user_id', $userId)->get()->toArray();
        if(!empty($userList)) {
            foreach ($userList as $user) {
                $userIds[] = $user['_id'];
                $dataUser[$user['_id']] = $user['fullname'];
            }
        }
        $listService = Service::whereIn('user_id', $userIds)->get()->toArray();
        if(!empty($listService)) {
            foreach ($listService as $service) {
                $serviceIds[] = $service['code'];
            }
        }
        $listLog = ServiceLog::whereIn('service_code', $serviceIds)->where('date', $date)->paginate(100);
        $dataLog = [];
        if(!empty($listLog)) {
            foreach ($listLog as $log) {
                $ListScanPost = ScanPost::where('log_id', $log['_id'])->get()->toArray();
                $log['service'] = Service::where('code', $log['service_code'])->get()->first();
                $log['countPost'] = count($ListScanPost);
                $dataLog[] = $log;
            }
        }
        return view('website.pages.service.history_list', compact('services', 'dataLog', 'dataUser', 'date', 'listLog'));
    }

    public function report(Request $request) {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect()->route('admin.login');
        }
        $userId = $checkLogin['userId'];
        $userIds = [];
        $serviceIds = [];
        $dataUser = [];
        $feeItem = Fee::where('type',2)->first();
        $date = !empty($request->input('date')) ? $request->input('date') : date('Y-m-d');
        $week = (int)date('W',strtotime($date));
        $month = (int)date('m',strtotime($date));
        $year = (int)date('Y',strtotime($date));
        $userList = User::where('referrer_user_id', $userId)->get()->toArray();
        if(!empty($userList)) {
            foreach ($userList as $user) {
                $userIds[] = $user['_id'];
                $dataUser[$user['_id']] = $user['fullname'];
            }
        }
        $listService = Service::whereIn('user_id', $userIds)->get()->toArray();
        if(!empty($listService)) {
            foreach ($listService as $service) {
                $serviceIds[] = $service['code'];
            }
        }
        $listLog = ServiceLog::whereIn('service_code', $serviceIds)->where('week', $week)->where('month', $month)->where('year', $year)->paginate(100);
        $dataLog = [];
        $sumMoney = 0;
        if(!empty($listLog)) {
            foreach ($listLog as $log) {
                $ListScanPost = ScanPost::where('log_id', $log['_id'])->get()->toArray();
                $log['service'] = Service::where('code', $log['service_code'])->get()->first();
                if($log['status'] == 2) {
                    $sumMoney = $sumMoney + $log['service']['price'];
                }
                $log['countPost'] = count($ListScanPost);
                $dataLog[] = $log;
            }
        }
        $feeMax = Fee::where('money','>=', $sumMoney)->where('type', 1)->orderBy('money', 'ASC')->first();
        $bonusRevenue = $feeMax['bonus'];
        return view('website.pages.service.report', compact('services', 'dataLog', 'dataUser', 'week', 'year', 'date', 'listLog', 'feeItem', 'bonusRevenue', 'sumMoney'));
    }

    public function indexType(Request $request, $type)
    {
        if (!in_array($type, ['likepost', 'addfriend', 'likepage'])) {
            return view('website.pages.service.no-service');
        }
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect()->route('admin.login');
        }
        $userId = $checkLogin['userId'];
        $services = Service::where('user_id', $userId)
            ->where('type', $type)
            ->orderBy('created_at', 'DESC')
            ->paginate(100);
        //modify list service log data
        $listServiceLog = [];
        return view('website.pages.service.historyType', compact('services', 'listServiceLog', 'type'));
    }

    public function create()
    {
        $settingsSingleton = new SettingSingleton();
        $settings = $settingsSingleton->getSetting();
        return view('website.pages.service.create', compact('settings'));
    }

    public function apiUpdateStatus(Request $request)
    {
        try {
            $setting = Setting::all()->keyBy('key');
            $LoginHelper = new LoginHelper();
            $checkLogin = $LoginHelper->checkSession();
            if(!$checkLogin) {
                return redirect()->route('admin.login');
            }
            $userId = $checkLogin['userId'];
            $userDetail = User::where('_id', $userId)->first();
            $serviceCode = $request->input('code');
            $serviceStatus = $request->input('status');
            $service = Service::where('user_id', $userId)->where('code', $serviceCode)->with('user')->first();

            //check if status change to Active and service was expired
            $dateNow = date('Y-m-d');
            if ($serviceStatus == Service::STATUS_ACTIVE) {
                if ($userDetail['balance'] < $setting['viplike_cost_per_day']->value) {
                    return ResponseJson::responseError([], 'Số dư không đủ để kích hoạt dịch vụ. Xin vui lòng nạp thêm.');
                }
                $refundValue = $setting['viplike_cost_per_day']->value;
                $balance = $userDetail['balance'] - $refundValue;
                $balance_use = isset($userDetail['balance_use']) ? $userDetail['balance_use'] + $refundValue : 0;
                User::where('_id', $userId)->update(['balance' => (int)$balance, 'balance_use' => (int)$balance_use]);
                $this->saveLog($serviceCode, $service->type);
                //save new expired time
            } else {
                ServiceLog::where('date', date('Y-m-d'))->where('service_code', $serviceCode)->update(['status' => 3]);
            }
            Service::where('code', $service->code)->update([
                'status' => $serviceStatus,
                'date_expired' => date('Y-m-d H:i:s')
            ]);
            $service = Service::where('user_id', $userId)->where('code', $serviceCode)->with('user')->first();
            return ResponseJson::responseSuccess($service, 'Cập nhật dịch vụ thành công');
        } catch (\Exception $exception) {
            return ResponseJson::systemError($exception);
        }
    }

    public function apiCancel(Request $request)
    {
        try {
            $LoginHelper = new LoginHelper();
            $checkLogin = $LoginHelper->checkSession();
            if(!$checkLogin) {
                return redirect()->route('admin.login');
            }
			$setting = Setting::all()->keyBy('key');
            $userId = $checkLogin['userId'];
            $userDetail = User::where('_id', $userId)->first();
            $serviceCode = $request->input('code');
            $service = Service::where('user_id', $userId)->where('code', $serviceCode)->with('user')->first();

            //check if status change to Active and service was expired
            if ($service->status == Service::STATUS_ACTIVE) {
                if ($service->number_likes - $service->number  >= $service->number) {
                    return ResponseJson::responseError([], 'Dịch vụ đã chạy xong, không thể hủy.');
                }
                if ($service->type == Service::TYPE_VIPLIKE ) {
                    return ResponseJson::responseError([], 'Không thể hủy loại dịch vụ này.');
                }
                //calculate price
                $listServicePrice = [
                    'likepost' => 10,
                    'likepage' => $setting['like_page']->value,
                    'addfriend' => $setting['sub_follow']->value,
                ];
                $refundValue = $listServicePrice[$service->type] * ($service->number_likes);

                //update service
                Service::where('code', $service->code)->update([
                    'status' => Service::STATUS_CANCEL,
                    'cancelled_at' => date('Y-m-d H:i:s')
                ]);
                //update user balance
                $balance = $userDetail['balance'] + $refundValue;
                User::where('_id', $userId)->update(['balance' => (int)$balance]);
                ServiceLog::where('date', date('Y-m-d'))->where('service_code', $serviceCode)->update(['status' => 1]);
            }
            return ResponseJson::responseSuccess(
                $service,
                "Hủy dịch vụ thành công. Số tiền {$refundValue} vnđ đã được hoàn lại số dư của tài khoản"
            );
        } catch (\Exception $exception) {
            return ResponseJson::systemError($exception);
        }
    }

    public function apiCreate(Request $request)
    {
        try {
            $setting = Setting::all()->keyBy('key');
            $LoginHelper = new LoginHelper();
            $checkLogin = $LoginHelper->checkSession();
            if(!$checkLogin) {
                return redirect()->route('admin.login');
            }
            $userId = $checkLogin['userId'];
            $userDetail = User::where('_id', $userId)->first();
            $balance = $userDetail['balance'];
            //$balance_use = isset($userDetail['balance_use']) ? $userDetail['balance_use'] : 0;
            if($request['type'] == 1) {
                $price = $setting['viplike_cost_per_day']->value;
            } else {
                $price = $setting['viplike_cost_per_month']->value;
            }
            if ($balance < $setting['viplike_cost_per_day']->value) {
                return ResponseJson::responseError([], 'Số dư của bạn không đủ, vui lòng nạp tiền để sử dụng dịch vụ');
            }
            $fanpageId = $request->input('fanpage_id');
            $fanpageId = str_replace('https://www.facebook.com/profile.php?id=', '', $fanpageId);
            $fanpageId = str_replace('https://m.facebook.com/profile.php?id=', '', $fanpageId);
            $fanpageId = str_replace('https://www.facebook.com/', '', $fanpageId);
            $fanpageId = str_replace('https://m.facebook.com/', '', $fanpageId);
            $service = new Service([
                'code' => StringHelper::generateCode(),
                'user_id' => $userId,
                'type' => 'viplike',
                'time_used' => $request['type'],
                'fanpage_id' => str_replace("/","",$fanpageId),
                'number_likes' => 0,
                'day_deff' => 2,
                'day_add' => 0,
                'uid_status' => 'true',
                'status' => 'Active',
                'date_expired' => date('Y-m-d'),
            ]);

            //calculate price
            $listServicePrice = [
                'likepost' => 10,
                'likepage' => $setting['like_page']->value,
				'addfriend' => $setting['sub_follow']->value,
            ];


            //type
            if (in_array($request->type, ['likepost', 'addfriend', 'likepage'])) {
                $service->type = $request->type;
                if (!is_numeric($request->number)) {
                    return ResponseJson::responseError([], 'Số lượng không đúng định dạng');
                }
                if ($request->number < 100) {
                    return ResponseJson::responseError([], 'Số lượng mua tối thiểu là 100');
                }
                $service->number = intval($request->number);
                $service->number_likes = intval($request->number);
                $price = $listServicePrice[$request->type] * intval($request->number);
            }
            $service->price = intval($price);
            if ($balance < $price) {
                return ResponseJson::responseError([], 'Số dư của bạn không đủ, vui lòng nạp tiền để sử dụng dịch vụ');
            }
            $code = $service->code;
            $service->save();
            $this->saveLog($code, $service->type);
            $balance = $userDetail['balance'] - $price;
            User::where('_id', $userId)->update(['balance' => (int)$balance]);
            $service->balance = number_format($balance);
            return ResponseJson::responseSuccess($service, 'Mua dịch vụ thành công. Bạn có thể xem trạng thái tại trang lịch sử gói dịch vụ.');
        } catch (\Exception $exception) {
            DB::rollBack();
            return ResponseJson::systemError($exception);
        }
    }

    function saveLog($serviceCode, $type) {
        if($type == 'viplike') {
            $dataSave = [
                'type' => '1',
                'fbid' => '',
                'action' => 'Buy Viplike',
                'comment' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'service_code' => $serviceCode
            ];
            Logs::insert($dataSave);
        }
        $checkExist = ServiceLog::where('date', date('Y-m-d'))->where('service_code', $serviceCode)->where('status', 0)->first();
        if(empty($checkExist)) {
            $dataServiceLog = [
                'service_code' => $serviceCode,
                'date' => date('Y-m-d'),
                'number_post' => 0,
                'status' => 0,
                'week' => (int)date('W'),
                'month' => (int)date('m'),
                'year' => (int)date('Y'),
                'type' => $type,
                'number_like_per_post' => 0,
            ];
            ServiceLog::create($dataServiceLog);
        }
    }
}