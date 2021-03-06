<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/22/2018
 * Time: 00:01 AM
 */

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;

class Setting extends \Moloquent
{
    use Notifiable;

    use HasTimestamps;
    protected $connection = 'mongodb';
    protected $collection = 'settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'key', 'value', 'description', 'created_at', 'updated_at'
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
