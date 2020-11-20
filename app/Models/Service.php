<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/20/2018
 * Time: 9:16 PM
 */

namespace App\Models;


class Service extends \Moloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'services';
    const STATUS_ACTIVE = 'Active';
    const STATUS_PAUSE = 'Pause';
    const STATUS_CANCEL = 'Cancel';
    const AGENT_STATUS_PREQUEUE = 'PreQueue';
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
        'id', 'code', 'user_id', 'number_likes', 'status', 'fanpage_id', 'date_expired', 'note', 'agent_status',
        'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return mixed
     */
    public function getExpiredServices()
    {
        $yesterday = date("Y-m-d", strtotime( '-1 days' ) );
        $expiredServices = Service::where('status', Service::STATUS_ACTIVE)
            ->where('type', Service::TYPE_VIPLIKE)
            ->where(function ($query) use ($yesterday) {
                $query->where('date_expired', '=', $yesterday)
                    ->orWhereNull('date_expired');
            })
            ->limit(env('SCAN_EXPIRED_SERVICE_PER_MINUTE', 100))
            ->with('user')
            ->get();
        return $expiredServices;
    }

    /**
     * @return mixed
     */
    public function preQueueService()
    {
        $preQueueServices = Service::where('agent_status', Service::AGENT_STATUS_PREQUEUE)
            ->where('status', Service::STATUS_ACTIVE)
            ->limit(env('ADD_SERVICE_TO_QUEUE_PER_MINUTE', 100))
            ->with('user')
            ->get();
        return $preQueueServices;
    }
}