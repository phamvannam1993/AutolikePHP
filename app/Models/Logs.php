<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/20/2018
 * Time: 9:16 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;

class Logs extends \Moloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'logs';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'code', 'created_at', 'updated_at'
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