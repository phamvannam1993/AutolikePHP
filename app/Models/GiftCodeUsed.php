<?php
/**
 * Created by PhpStorm.
 * User: ductho1201
 * Date: 12/26/2018
 * Time: 11:28 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;

class GiftCodeUsed extends \Moloquent
{
    use HasTimestamps;
    protected $connection = 'mongodb';
    protected $collection = 'gift_code_used';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'gift_code_id', 'gift_code', 'value',
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
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function giftCode()
    {
        return $this->belongsTo(GiftCode::class, 'gift_code_id', 'id');
    }
}