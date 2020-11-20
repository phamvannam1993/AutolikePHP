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

class Manager extends Authenticatable
{
    use Notifiable;

    protected $connection = 'mongodb';
    protected $collection = 'managers';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password', 'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function checkLogin($params)
    {
        $params = [
            'phone' => $params['phone'],
            'password' => $params['password']
        ];
        if (!$params['phone'] || !$params['password']) {
            return false;
        }
        $manager = self::where('phone', $params['phone'])->first();
        if (!$manager) {
            return false;
        }
        if (!Hash::check($params['password'], $manager->password)) {
            return false;
        }
        return $manager;
    }
}
