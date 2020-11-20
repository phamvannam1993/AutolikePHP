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
use App\Models\Package;
use App\Models\Device;
use App\Models\GroupProfile;
use App\Models\ActionProfile;
use Illuminate\Http\Request;
use App\Helpers\LoginHelper;

class PackageController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $packageList = Package::paginate(100);
        return view('admin.package.list', ['packageList' => $packageList]);
    }

    public function form(request $request) {
        if(!empty($request['package'])) {
            $package = $request['package'];
            $package['updated_at'] = date('Y-m-d H:i:s');
            $package['created_at'] = date('Y-m-d H:i:s');
            $package['money'] = (int) $package['money'];
            $package['bonus'] = (int) $package['bonus'];
            if($request['packageId'] == 0) {
                $result = Package::insert($package);
            } else {
                $result = Package::where('_id', $request['packageId'])->update($package);
            }

            if($result) {
                return redirect(route('admin.package.list'));
            }
        }
        $packageDetail = [];
        if($request['packageId']) {
            $packageDetail = Package::where('_id', $request['packageId'])->get()->first();
        }
        $dataList = ['packageDetail' => $packageDetail];
        return view('admin.package.form', $dataList);
    }

    public function delete($userId = 0) {
        if($userId > 0) {
           $result = Package::where('_id', $userId)->delete();
           if($result > 0) {
               return redirect(route('admin.package.list'));
           }
        }
    }

}
