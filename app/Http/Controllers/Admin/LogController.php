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
use App\Models\Logs;
use App\Models\Service;
use App\Models\Fee;
use App\Helpers\LoginHelper;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function __construct()
    {
    }

    public function listLog(Request $request)
    {
        $LoginHelper = new LoginHelper();
        $checkLogin = $LoginHelper->checkSession();
        if(!$checkLogin) {
            return redirect(route('admin.login'));
        }
        $service_code = $request['service_code'] ? $request['service_code'] : '';
        $fbid = $request['fbid'] ? $request['fbid'] : '';
        $where = [];
        if(!empty($service_code)) {
            $where[] = ['service_code', 'like', '%'.$service_code.'%'];
        }
        if(!empty($fbid)) {
            $where[] = ['fbid', 'like', '%'.$fbid.'%'];
        }
        if(!empty($where)) {
            $logList = Logs::orderBy('_id', 'DESC')->where($where)->paginate(50);
        } else {
            $logList = Logs::orderBy('_id', 'DESC')->paginate(50);
        }
        for ($i = 0; $i < count($logList); $i++) {
            $serviceItem = Service::where('code', $logList[$i]['service_code'])->first();
            $logList[$i]['uid'] = isset($serviceItem['fanpage_id']) ? $serviceItem['fanpage_id'] : '';
        }
        return view('admin.log.index', ['logList' => $logList, 'service_code' => $service_code, 'fbid' => $fbid]);
    }

    function getType($type) {
        switch ($type) {
            case 'viplike':
                return '1';
                break;
            case 'scanpost':
                return '2';
                break;
            case 'DoAction':
                return '3';
                break;
            default:
                return '4';
                break;
        }
    }
}
