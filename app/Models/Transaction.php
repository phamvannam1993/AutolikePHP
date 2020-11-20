<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/19/2018
 * Time: 9:18 AM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends \Moloquent
{
    const STATUS_PENDING = 'Pending';
    const STATUS_COMPLETED = 'Completed';
    const STATUS_EXPIRED = 'Expired';

    protected $connection = 'mongodb';
    protected $collection = 'transacions';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'user_id', 'value', 'note', 'completed_at', 'accepted_by', 'status', 'bonus',
        'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
}