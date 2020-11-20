<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/26/2018
 * Time: 11:28 PM
 */

namespace App\Models;


class ScanPost extends  \Moloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'scan_post';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'log_id', 'post_time', 'updated_time', 'uid_liker',
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

}