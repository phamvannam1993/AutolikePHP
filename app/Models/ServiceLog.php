<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/27/2018
 * Time: 11:36 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;

class ServiceLog extends \Moloquent
{
//    use HasTimestamps;
    protected $connection = 'mongodb';
    protected $collection = 'service_log';

    const AGENT_STATUS_INQUEUE = 'InQueue';
    const AGENT_STATUS_RUNNING = 'Running';
    const AGENT_STATUS_COMPLETED = 'Completed';
    const TYPE_VIPLIKE = 'viplike';
    const TYPE_ADDFRIEND = 'addfriend';
    const TYPE_LIKE_PAGE = 'likepage';
    const TYPE_LIKE_POST = 'likepost';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service_code', 'fbid', 'user_id', 'date', 'week', 'month', 'year', 'number_post', 'number_like_per_post', 'status', 'agent_status',
        'type', 'number', 'uid_likers', 'last_time_scan', 'posts', 'count_posts',
        'created_at', 'updated_at', 'updated_time'
    ];

    protected $casts = [
        'updated_at' => 'string',
        'created_at' => 'string'
    ];

//    public function setUpdateAtAttribute($value)
//    {
//        $this->attributes['updated_at'] = (string) $value;
//    }

//    public $timestamps = true;
//    protected $dates = ['created_at', 'updated_at'];
//    public function getDates()
//    {
//        return ['created_at', 'updated_at'];
//    }
}