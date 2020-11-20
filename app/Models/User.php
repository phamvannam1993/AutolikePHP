<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/22/2018
 * Time: 6:21 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;

class User extends \Moloquent
{
    use HasTimestamps;
    const STATUS_ACTIVE = 'Active';
    const STATUS_BLOCK = 'Block';
    protected $connection = 'mongodb';
    protected $collection = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        '_id', 'username', 'password', 'invite_code', 'agency_status', 'deposit_amount', 'balance_use', 'referrer_code', 'referrer_user_id', 'name', 'fullname', 'status', 'role', 'pass_show', 'email', 'token', 'created_at', 'updated_at'
    ];
    public $timestamps = true;
    protected $dates = ['created_at', 'updated_at'];
    public function getDates()
    {
        return ['created_at', 'updated_at'];
    }
}