<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/20/2018
 * Time: 9:16 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;

class Service extends \Moloquent
{
    const STATUS_ACTIVE = 'Active';
    const STATUS_PAUSE = 'Pause';
    const STATUS_CANCEL = 'Cancel';
    const TYPE_VIPLIKE = 'viplike';
    const TYPE_ADDFRIEND = 'addfriend';
    const TYPE_LIKE_PAGE = 'likepage';
    const TYPE_LIKE_POST = 'likepost';

    protected $connection = 'mongodb';
    protected $collection = 'services';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'code', 'user_id', 'number_likes', 'day_add', 'status', 'uid_status', 'fanpage_id', 'date_expired', 'agent_status', 'type', 'price', 'time_used', 'day_deff',
        'number', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}