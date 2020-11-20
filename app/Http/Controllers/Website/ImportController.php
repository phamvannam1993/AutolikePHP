<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/22/2018
 * Time: 5:16 PM
 */

namespace App\Http\Controllers\Website;

use App\Helpers\Like4VipApi;
use App\Helpers\ResponseJson;
use App\Http\Controllers\Controller;
use App\Models\FacebookBot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\LoginHelper;

class ImportController extends Controller
{
    public function __construct()
    {
    }

    public function formImport()
    {
        return view('website.pages.import.formImport');
    }

    public function apiImportData(Request $request)
    {
        $data = $request->input('data');
        $listRowData = explode(PHP_EOL, $data);
        $listBotData = [];
        foreach ($listRowData as $row) {
            $explodeData = explode('|', $row);
            $botData = [];
            foreach ($explodeData as $fieldData) {
                if (strpos($fieldData, '100') === 0) {
                    $botData['uid'] = $fieldData;
                }
                if (strpos($fieldData, 'EAA') === 0) {
                    $botData['token'] = $fieldData;
                }
            }
            if (!empty($botData) && !empty($botData['uid'])) {
                $botData['status'] = FacebookBot::STATUS_ACTIVE;
                array_push($listBotData, $botData);
            }

//            array_push($listBotData, [
//                'uid' => $explodeData[0],
//                'email' => $explodeData[1],
//                'password' => $explodeData[2],
//                'cookie' => $explodeData[3],
//                'token' => $explodeData[4],
//                'status' => 'Active',
//                'created_at' => date('Y-m-d H:i:s'),
//                'updated_at' => date('Y-m-d H:i:s'),
//            ]);
        }
        $insertData = DB::connection('mongodb')->collection('facebook_bot')->insert($listBotData);
        return ResponseJson::responseSuccess([], 'Import thành công');
    }
}