<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/20/2018
 * Time: 9:04 PM
 */

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseJson;
use App\Http\Controllers\Controller;
use App\Models\FacebookBot;
use App\Models\Setting;
use App\Models\TokenLog;
use Illuminate\Http\Request;

class FacebookTokenController extends Controller
{
    protected $setting;
    public function __construct()
    {
        $this->setting = Setting::all()->keyBy('key');
    }

    public function getTokens(Request $request)
    {
        $timeRequestMinuteAgo = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s"). " -" . $this->setting['time_cycle_use_token']->value . " minutes"));
        $limit = !empty($request->limit) ? ($request->limit) : 50;
        if ($limit == 'all') {
            $fbTokens = FacebookBot::select('uid', 'token')
                ->where('status', FacebookBot::STATUS_ACTIVE)
                ->where('updated_at', '<', $timeRequestMinuteAgo)
                ->orderBy('updated_at', 'ASC')
                ->get();
        } else {
            $fbTokens = FacebookBot::select('uid', 'token')
                ->where('status', FacebookBot::STATUS_ACTIVE)
                ->limit(intval($limit))
                ->where('updated_at', '<', $timeRequestMinuteAgo)
                ->orderBy('updated_at', 'ASC')
                ->get();
            $listIdMongo = $fbTokens->pluck('_id')->toArray();
            $updateToken = FacebookBot::whereIn('_id', $listIdMongo)->update(['updated_at' => date('Y-m-d H:i:s')]);
        }
        return ResponseJson::responseSuccess($fbTokens, 'Fetch token success');
    }

    public function updateTokens(Request $request)
    {
        $listUid = $request->input('list_uid');
        $status = $request->input('status');
        $listUid = explode(',', $listUid);
        FacebookBot::whereIn('uid', $listUid)->update(['status' => $status, 'updated_at' => date('Y-m-d H:i:s')]);
        return ResponseJson::responseSuccess(null, 'Update success');
    }

    public function createToken(Request $request)
    {
        $tokenData = $request->only(['uid', 'email', 'password', 'cookie', 'token']);
        $tokenData['status'] = 'Active';
        $token = FacebookBot::updateOrCreate(
            ['uid' => $tokenData['uid']],
            $tokenData
        );
        return ResponseJson::responseSuccess($token, 'Fetch token success');
    }

    public function logEvent(Request $request)
    {
        $_tokenEventsData = $request->getContent();
        $tokenEvents = json_decode($_tokenEventsData, TRUE);
        foreach ($tokenEvents as $event) {
            $tokenLog = TokenLog::create([
                'uid' => $event['uid'],
                'token' => $event['token'],
                'service_code' => $event['service_code'],
                'fbid' => $event['fbid'],
                'post_id' => $event['post_id'],
                'action_time' => $event['action_time'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
        return ResponseJson::responseSuccess(null, 'Update success');
    }
}
