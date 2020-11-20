<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/27/2018
 * Time: 11:36 PM
 */

namespace App\Models;

class BotRunService extends \Moloquent
{
//    use HasTimestamps;
    protected $connection = 'mongodb';
    protected $collection = 'bot_run_service';

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
        'service_code', 'fbid', 'fb_bot_id', 'date', 'type_service', 'type_object',
        'created_at', 'updated_at', 'updated_time'
    ];

    protected $casts = [
        'updated_at' => 'string',
        'created_at' => 'string'
    ];
}