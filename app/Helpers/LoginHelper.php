<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/19/2018
 * Time: 9:46 AM
 */

namespace App\Helpers;
use App\Models\User;

class LoginHelper
{
    public function checkSession() {
        $language = \Session::get('website_language', config('app.locale'));
        if($language) {
            \App::setLocale($language);
        }
		$value = session('dataLogin');
		if($value) {
		    $userDetail = User::where('_id', $value['userId'])->where('status', User::STATUS_ACTIVE)->first();
            $dataLogin = $userDetail;
            if($userDetail) {
                $dataLogin['userId'] = $userDetail['_id'];
                session(['dataLogin' => $dataLogin]);
            } else {
                session(['dataLogin' => '']);
                return false;
            }
			return $value;
		} else {
			return false;
		}
    }

    public function getListAction() {
        $actionList = [
            1 => [
                'key' => 1,
                'value' => 'vip like'
            ],
            2 => [
                'key' => 16,
                'value' => 'Likepage'
            ],
            3 => [
                'key' => 17,
                'value' => 'sub/follow'
            ],
            4 => [
                'key' => 2,
                'value' => 'Add Friend Suggest'
            ],
            5 => [
                'key' => 3,
                'value' => 'Add Friend By UID'
            ],
            6 => [
                'key' => 4,
                'value' => 'Confirm Friend'
            ],
            7 => [
                'key' => 5,
                'value' => 'post'
            ],
            8 => [
                'key' => 6,
                'value' => 'Join Group'
            ],
            9 => [
                'key' => 7,
                'value' => 'Share Profile'
            ],
            10 => [
                'key' => 8,
                'value' => 'Share Group'
            ],
            11 => [
                'key' => 9,
                'value' => 'Friend Request Delete'
            ],
            12 => [
                'key' => 10,
                'value' => 'grouplike'
            ],
            13 => [
                'key' => 11,
                'value' => 'Change Password'
            ],
            14 => [
                'key' => 12,
                'value' => 'Avatar'
            ],
            15 => [
                'key' => 13,
                'value' => 'Cover'
            ],
            16 => [
                'key' => 14,
                'value' => 'Photo'
            ],
            17 => [
                'key' => 15,
                'value' => 'Change Info'
            ],
        ];
        return $actionList;
    }
}