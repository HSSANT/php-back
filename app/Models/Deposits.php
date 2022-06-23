<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposits extends Model
{
    protected $fillable = [
        'user_id', 'description', 'authorized_by', 'authorized','amount','checkbook_image','created_at','type',
    ];


    /**
     * Returns user who made the deposit
     * @author   Herbert Santos<herbert.aga@gmail.com>
     */
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    
    /**
     * Return user who approved the Deposit
     * @author   Herbert Santos<herbert.aga@gmail.com>
     */
    public function authorizedBy(){
        return $this->belongsTo(User::class,'authorized_by');
    }
}
