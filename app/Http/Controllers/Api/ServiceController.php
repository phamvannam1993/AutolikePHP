<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/20/2018
 * Time: 9:04 PM
 */

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseJson;
use App\Models\BotRunService;
use App\Models\Service;
use App\Models\ServiceLog;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ServiceController
{
    protected $setting;
    public function __construct()
    {
        $this->setting = Setting::all()->keyBy('key');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function serviceInQueue(Request $request)
    {
        try {
            $limit = !empty($request->limit) ? intval($request->limit) : 50;
            $servicesLog = ServiceLog::where('agent_status', ServiceLog::AGENT_STATUS_INQUEUE)
                ->where('type', ServiceLog::TYPE_VIPLIKE)
                ->where('date', date('Y-m-d'))
                ->limit($limit)
                ->orderBy('updated_time', 'ASC')
                ->get();

            //test service code
            $listServiceCode = $servicesLog->pluck('service_code')->toArray();
            $servicesCode = implode(',', $listServiceCode);
            Log::info('log_service_get_list_' . $servicesCode);

            $listId = $servicesLog->pluck('_id')->toArray();
            $updateTime = ServiceLog::whereIn('service_code', $listServiceCode)->where('date', date('Y-m-d'))
                ->update([
                    'updated_time' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            return ResponseJson::responseSuccess($servicesLog, 'Success');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return ResponseJson::systemError($exception);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateService(Request $request)
    {
        $_serviceData = $request->getContent();
        $service = json_decode($_serviceData, TRUE);
        $listScannedPost = $service['posts'];
        $serviceData = ServiceLog::where('_id', $service['_id'])->first();
        Log::info('0_log_service_update_service_' . $service['service_code']);
        Log::info('0_log_service_update_service_data:' . json_encode($_serviceData));
        $service['updated_at'] = date('Y-m-d H:i:s');
        $service['updated_time'] = date('Y-m-d H:i:s');
        $service['agent_status'] = ($this->checkNeedRunAgain($service)) ? ServiceLog::AGENT_STATUS_INQUEUE : ServiceLog::AGENT_STATUS_COMPLETED;
        $service['posts'] = $serviceData['posts'];
        foreach ($listScannedPost as $key => $post) {
            if (!isset($service['posts'][$key])) {
                $service['posts'][$key]['likes'] = [];
            }
        }

        $service['count_posts'] = count($service['posts']);
        $_id = $service['_id'];
        unset($service['_id']);
        $updateService = ServiceLog::where('_id', $_id)->update($service);
        return ResponseJson::responseSuccess($service, 'Cập nhật thành công.');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function scanPostService(Request $request)
    {
        $_serviceData = $request->getContent();
        $service = json_decode($_serviceData, TRUE);
        $listScannedPost = $service['posts'];
        $serviceData = ServiceLog::where('_id', $service['_id'])->first();
        Log::info('0_log_service_update_service_' . $service['service_code']);
        Log::info('0_log_service_update_service_data:' . json_encode($_serviceData));
        $service['updated_at'] = date('Y-m-d H:i:s');
        $service['updated_time'] = date('Y-m-d H:i:s');
        $service['agent_status'] = ($this->checkNeedRunAgain($service)) ? ServiceLog::AGENT_STATUS_INQUEUE : ServiceLog::AGENT_STATUS_COMPLETED;
        $service['posts'] = $serviceData['posts'];
        foreach ($listScannedPost as $key => $post) {
            if (!isset($service['posts'][$post['post_id']])) {
                $service['posts'][$post['post_id']]['likes'] = [];
            }
        }

        $service['count_posts'] = count($service['posts']);
        $_id = $service['_id'];
        unset($service['_id']);
        $updateService = ServiceLog::where('_id', $_id)->update($service);
        return ResponseJson::responseSuccess($service, 'Cập nhật thành công.');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function mobileGetService(Request $request)
    {
        try {
            $limit = !empty($request->limit) ? intval($request->limit) : 50;
            $type = $request->type ? $request->type : ServiceLog::TYPE_VIPLIKE;
            $botFbId = $request->input('fbid');
            $query = ServiceLog::select('service_code', 'fbid', 'type')
                ->where('agent_status', ServiceLog::AGENT_STATUS_INQUEUE)
                ->where('type', $type)
                ->limit($limit)
//                ->groupBy('fbid')
                ->orderBy('updated_time', 'ASC');
            if ($type == ServiceLog::TYPE_VIPLIKE) {
                $query->where('count_posts', ">", 0)->where('date', date('Y-m-d'));
            }

            //ignore service is likepage and sub have relation with bot fb id
            if (in_array($type, [Service::TYPE_ADDFRIEND, Service::TYPE_LIKE_PAGE])) {
                //list fb id
                $services = BotRunService::where('fb_bot_id', $botFbId)
                    ->where('type_service', $type)
                    ->get();
                $ignoreFbIds = $services->pluck('fbid')->toArray();
                $query->whereNotIn('fbid', $ignoreFbIds);
            }

            $servicesLog = $query->get();

            //test service code
            $listServiceCode = $servicesLog->pluck('service_code')->toArray();
            $servicesCode = implode(',', $listServiceCode);
            Log::info('log_service_get_list_' . $servicesCode);

            $listId = $servicesLog->pluck('_id')->toArray();
            $updateTime = ServiceLog::whereIn('service_code', $listServiceCode)
                ->update([
                    'updated_time' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'agent_status' => ($type == Service::TYPE_VIPLIKE) ? ServiceLog::AGENT_STATUS_INQUEUE : ServiceLog::AGENT_STATUS_INQUEUE
                ]);
            return ResponseJson::responseSuccess($servicesLog, 'Success');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return ResponseJson::systemError($exception);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function mobileUpdateService(Request $request)
    {
        $_serviceData = $request->getContent();
        $serviceData = json_decode($_serviceData, TRUE);
        Log::info('1_log_service_update_service_' . $serviceData['service_code']);
        Log::info('1_log_service_update_service_data:' . json_encode($serviceData));
        $serviceData['updated_at'] = date('Y-m-d H:i:s');
        $serviceData['updated_time'] = date('Y-m-d H:i:s');
        $serviceLog = ServiceLog::where([
            ['service_code', $serviceData['service_code']],
        ])->orderBy('date', 'DESC')->first();
        if (!$serviceLog) {
            return ResponseJson::responseError([], 'Service log not found.');
        }
        //update service log
        $serviceLog->uid_likers = array_values(array_unique(array_merge($serviceLog->uid_likers, $serviceData['uid_likers'])));
        if (
            $serviceLog->type == ServiceLog::TYPE_VIPLIKE
            && count($serviceLog->uid_likers) >= $serviceLog->number_like_per_post
            && count($serviceLog->posts) >= $serviceLog->number_post
        ) {
            $serviceLog->agent_status = ServiceLog::AGENT_STATUS_COMPLETED;
        }

        if ($serviceLog->type !== ServiceLog::TYPE_VIPLIKE && count($serviceLog->uid_likers) >= $serviceLog->number) {
            $serviceLog->agent_status = ServiceLog::AGENT_STATUS_COMPLETED;
        }

        $postsData = [];
        foreach ($serviceLog['posts'] as $key => $value) {
            $postsData[$key]['likes'] = $serviceLog->uid_likers;
        }
        $serviceLog['posts'] = $postsData;

        $serviceLog->updated_at = date('Y-m-d H:i:s');
        $serviceLog->updated_time = date('Y-m-d H:i:s');
        $serviceLog->save();

        return ResponseJson::responseSuccess($serviceLog, 'Cập nhật thành công.');
    }

    public function mobileUpdateServiceV2(Request $request)
    {
        $_serviceData = $request->getContent();
        $serviceData = json_decode($_serviceData, TRUE);
        $serviceCode = $serviceData['service_code'];
        Log::info('2_log_service_update_service_' . $serviceData['service_code']);
        Log::info('2_log_service_update_service_data:' . json_encode($serviceData));
        $fbid = $serviceData['fbid'];
        $serviceLog = ServiceLog::where([
            ['service_code', $serviceCode],
        ])->orderBy('date', 'DESC')->first();
        if (!$serviceLog) {
            return ResponseJson::responseError([], 'Service log not found.');
        }
        //update service log
        $serviceLog->uid_likers = array_values(array_unique(array_merge($serviceLog->uid_likers, [$fbid])));
        if (
            $serviceLog->type == ServiceLog::TYPE_VIPLIKE
            && count($serviceLog->uid_likers) >= $serviceLog->number_like_per_post
            && count($serviceLog->posts) >= $serviceLog->number_post
        ) {
            $serviceLog->agent_status = ServiceLog::AGENT_STATUS_COMPLETED;
        }

        if ($serviceLog->type !== ServiceLog::TYPE_VIPLIKE && count($serviceLog->uid_likers) >= $serviceLog->number) {
            $serviceLog->agent_status = ServiceLog::AGENT_STATUS_COMPLETED;
        }

        $postsData = $serviceLog['posts'];
	foreach ($serviceLog['posts'] as $key => $value) {
	    array_push($postsData[$key]['likes'], $fbid);
            $postsData[$key]['likes'] = array_unique($postsData[$key]['likes']);
        }
        $serviceLog['posts'] = $postsData;

        $serviceLog->updated_at = date('Y-m-d H:i:s');
        $serviceLog->updated_time = date('Y-m-d H:i:s');
        $serviceLog->save();

        //update bot run service
        if (in_array($serviceLog->type, [Service::TYPE_ADDFRIEND, Service::TYPE_LIKE_PAGE])) {
            BotRunService::firstOrCreate(
                [
                    'service_code' => $serviceCode,
                    'fbid' => $serviceLog->fbid,
                    'fb_bot_id' => $fbid
                ],
                [
                    'type_service' => $serviceLog->type,
                    'updated_time' => date('Y-m-d H:i:s'),
                    'date' => date('Y-m-d'),
                    'type_object' => $this->getTypeObject($serviceLog)
                ]
            );
        }

        return ResponseJson::responseSuccess($serviceLog, 'Cập nhật thành công.');
    }

    public function logs(Request $request)
    {
        $_listCode = $request->input('list_code');
        $date = $request->input('date') ?: date('Y-m-d');
        $type = $request->input('type');
        $listCode = explode(',', $_listCode);
        if (in_array($request->type, ['likepost', 'addfriend', 'likepage'])) {
            $serviceLogs = ServiceLog::whereIn('service_code', $listCode)
                ->get();
        } else {
            $serviceLogs = ServiceLog::whereIn('service_code', $listCode)
                ->where('date', $date)
                ->get();
        }
        return ResponseJson::responseSuccess($serviceLogs, 'Fetch data success.');
    }

    /**
     * @param $serviceLog
     * @return bool
     */
    private function checkNeedRunAgain($serviceLog)
    {
        //check post is enough like
        if (empty($post['posts']) || (count($serviceLog['posts']) < $serviceLog['number_post']))
            return TRUE;
        foreach ($serviceLog['posts'] as $post) {
            if (empty($post['likes']) || (count($post['likes']) < $serviceLog['number_like_per_post']))
                return TRUE;
        }
        return FALSE;
    }

    private function getTypeObject($serviceLog)
    {
        if (in_array($serviceLog->type, [Service::TYPE_ADDFRIEND, Service::TYPE_LIKE_PAGE])) {
            return 'page';
        }
        return 'post';
    }
}
