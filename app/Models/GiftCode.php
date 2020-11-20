<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/26/2018
 * Time: 11:28 PM
 */

namespace App\Models;


class GiftCode extends  \Moloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'gift_code';
    CONST STATUS_ACTIVE = 'Active';
    CONST STATUS_PAUSE = 'Pause';
    CONST STATUS_STOP = 'Stop';
    CONST STATUS_EXPIRED = 'Expired';
    CONST STATUS_USED = 'Used';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'code', 'value', 'user_id', 'description', 'expired_time', 'remaining', 'status',
        'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}