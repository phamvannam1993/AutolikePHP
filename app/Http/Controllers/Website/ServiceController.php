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
use App\Models\ScanPost;
use App\Models\Service;
use App\Models\User;
use App\Models\ServiceHistory;
use App\Models\ServiceLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\LoginHelper;

class ServiceController
{
    public function __construct()
    {
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        $userList = User::get()->toArray();
        $userArr = [];
        if(!empty($userList)) {
            foreach ($userList as $user) {
                $userArr[$user['_id']] = isset($user['fullname']) ? $user['fullname'] : '';
            }
        }
        $status = $request->input('status');
        $date = !empty($request->input('date')) ? $request->input('date') : date('Y-m-d');
        if ($date == date('Y-m-d')) {
            if ($status) {
                $services = Service::where('status', $status)
                    ->where('type', Service::TYPE_VIPLIKE)
                    ->with('user')
                    ->where('status', $status)
                    ->orderBy('status', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->paginate(100);
            } else {
                $services = Service::with('user')
                    ->where('type', Service::TYPE_VIPLIKE)
                    ->orderBy('status', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->paginate(100);
            }
        } else if ($date < date('Y-m-d')) {
            $listServiceHistory = ServiceLog::where([
                ['date', $date],
            ])->get();
            $listServiceCode = $listServiceHistory->pluck('service_code')->toArray();
            $services = Service::whereIn('code', $listServiceCode)
                ->where('type', Service::TYPE_VIPLIKE)
                ->orderBy('status', 'ASC')
                ->orderBy('created_at', 'DESC')
                ->paginate(100);
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
                    $dataService[$service['code']]['date_time'] = !empty((int)$serviceLog['updated_at']) ? date('Y/m/d H:i:s', strtotime($serviceLog['updated_at'])) : date('Y/m/d H:i:s', strtotime($serviceLog['created_at']));
                    $dataService[$service['code']]['number_post'] = count($ListScanPost);
                    if(!empty($ListScanPost)) {
                        foreach ($ListScanPost as $scanPost) {
                            $postId = explode('_', $scanPost['id']);
                            $scanPost['link_post'] = isset($postId[1]) ? 'https://www.facebook.com/'.$postId[1] : '';
                            $dataLogService[$service['code']][] = $scanPost;
                        }
                    }
                }
            }
        }

        if ($date < date('Y-m-d')) {
            $listServiceHistory = $listServiceHistory->keyBy('service_code');
            return view('website.pages.service.history', compact('services', 'dataService', 'date', 'dataLogService', 'totalLikes'));
        }

        return view('website.pages.service.index', compact('services', 'date', 'dataService', 'dataLogService', 'userArr'));
    }

    public function indexType(Request $request, $type)
    {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        if (!in_array($type, ['likepost', 'addfriend', 'likepage'])) {
            return view('website.pages.service.no-service');
        }
        $userList = User::get()->toArray();
        $userArr = [];
        if(!empty($userList)) {
            foreach ($userList as $user) {
                $userArr[$user['_id']] = isset($user['fullname']) ? $user['fullname'] : '';
            }
        }
        $requester = Auth::user();
        $status = $request->input('status');
        $date = !empty($request->input('date')) ? $request->input('date') : date('Y-m-d');
        $services = Service::where('type', $type)
            ->with('user')
            ->orderBy('created_at', 'DESC')
            ->paginate(100);
        //get list like by service code
        $listServiceCode = $services->pluck('code')->toArray();
        //post data to admin
        $serviceLogData = ServiceLog::whereIn('service_code', $listServiceCode)
            ->where('type', $type)
            ->get()
            ->toArray();
        //modify list service log data
        $listServiceLog = collect($serviceLogData)->keyBy('service_code')->toArray();
        return view('website.pages.service.historyType', compact('services', 'listServiceLog', 'type', 'userArr'));
    }

    public function show(Request $request, $code)
    {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        $service = Service::where('code', $code)->first();
        $date = $request->input('date');
        if (!$service) {
            return view('website.pages.service.no-service');
        }

        //get log data
        $serviceLogRes = JavaJobApiHelper::requestApi(
            env('JAVA_JOB_API_URL') . '/fblike4vip/logs?code=' . $service->code . '&date=' . $date,
            'GET',
            []
        );

        $posts = [];
        $serviceLog = json_decode($serviceLogRes['response'], true);
        if (empty($serviceLog)) {
            return view('website.pages.service.show', compact('posts'));
        }
        //get list post and like number
        foreach ($serviceLog[0]['fbUid']['post_statuses'] as $key => $post) {
            array_push($posts, [
                'uid' => $post['postInfo']['post_id'],
                'likes' => $post['likes'],
                'number_likes' => count($post['likes']),
                'post_detail' => mb_substr($post['postInfo']['post_detail'], 0, 50) . '...',
                'created_at' => $post['postInfo']['post_dateStr']
            ]);
        }
        return view('website.pages.service.show', compact('posts'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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
            $service = Service::where('code', $serviceCode)->first();
            $service->status = $serviceStatus;
            //save new expired time
            $service->date_expired = date('Y-m-d');
            $service->save();

            //push data to java job
            $putServiceToJavaJobRes = JavaJobApiHelper::requestApi(
                env('JAVA_JOB_API_URL') . '/fblike4vip/services',
                'POST',
                [
                    'code' => $service->code,
                    'uid' => $service->fanpage_id,
                    'status' => ($service->status == Service::STATUS_ACTIVE) ? true : false
                ]
            );

            return ResponseJson::responseSuccess($service, 'Cập nhật dịch vụ thành công');
        } catch (\Exception $exception) {
            return ResponseJson::systemError($exception);
        }
    }
}