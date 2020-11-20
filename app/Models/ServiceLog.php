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
    use HasTimestamps;
    protected $connection = 'mongodb';
    protected $collection = 'service_log';

    const AGENT_STATUS_PREQUEUE = 'PreQueue';
    const AGENT_STATUS_INQUEUE = 'InQueue';
    const AGENT_STATUS_RUNNING = 'Running';
    const AGENT_STATUS_COMPLETED = 'Completed';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service_code', 'fbid', 'user_id', 'date', 'week', 'status_check', 'month', 'year', 'number_post', 'number_like_per_post', 'status', 'agent_status', 'number_likes',
        'type', 'number', 'uid_likers', 'last_time_scan', 'posts', 'count_posts', 'day_deff',
        'created_at', 'updated_at', 'updated_time'
    ];
    public $timestamps = true;
    protected $dates = ['created_at', 'updated_at'];
    public function getDates()
    {
        return ['created_at', 'updated_at'];
    }
}