<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buys extends Model
{
    protected $fillable = [
        'user_id', 'description','amount','created_at',
    ];

    /**
     * Returns user who made the buy
     * @author   Herbert Santos<herbert.aga@gmail.com>
     */
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }


}
