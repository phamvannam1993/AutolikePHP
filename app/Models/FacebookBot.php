<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/27/2018
 * Time: 11:36 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;

class FacebookBot extends \Moloquent
{
    use HasTimestamps;
    protected $connection = 'mongodb';
    protected $collection = 'facebook_bot';

    const STATUS_ACTIVE = 'Active';
    const STATUS_CHECKPOINT = 'Checkpoint';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        '_id', 'uid', 'password', 'cookie', 'token', 'status', 'created_at', 'updated_at', 'email', 'password'
    ];
    public $timestamps = true;
    protected $dates = ['created_at', 'updated_at'];
    protected $appends = ['time_delay'];
    protected $casts = [
        'time_delay' => 'integer'
    ];
    public function getDates()
    {
        return ['created_at', 'updated_at'];
    }

    public function getTimeDelayAttribute()
    {
        return 15;
    }
}