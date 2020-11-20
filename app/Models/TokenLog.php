<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/27/2018
 * Time: 11:36 PM
 */

namespace App\Models;

class TokenLog extends \Moloquent
{
//    use HasTimestamps;
    protected $connection = 'mongodb';
    protected $collection = 'token_log';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service_code', 'fbid', 'post_id', 'uid', 'token', 'action_time', 'created_at', 'updated_at'
    ];
}