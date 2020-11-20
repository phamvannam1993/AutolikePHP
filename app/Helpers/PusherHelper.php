<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/26/2018
 * Time: 12:26 AM
 */

namespace App\Helpers;

use Pusher\Pusher;

class PusherHelper
{
    public function pushNotify($channel, $event, $data)
    {
        $options = array(
            'cluster' => env('PUSHER_APP_CLUSTER', 'ap1'),
            'useTLS' => true
        );
        $pusher = new Pusher(
            env('PUSHER_APP_KEY', '7e4eaeb1b8ee811d33f2'),
            env('PUSHER_APP_SECRET', 'e853367a15affa513bc5'),
            env('PUSHER_APP_ID', '679093'),
            $options
        );
        return $pusher->trigger($channel, $event, $data);
    }
}