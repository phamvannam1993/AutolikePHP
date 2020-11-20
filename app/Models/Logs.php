<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/26/2018
 * Time: 11:28 PM
 */

namespace App\Models;


class Logs extends  \Moloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'uid', 'service_code', 'type', 'fbid', 'action', 'comment', 'updated_time', 'uid_liker',
        'created_at', 'updated_at'
    ];

}