<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasPermissions;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles, HasPermissions;

    protected $guard_name = 'api';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     /**
     * Hash typed password
     * @author   Herbert Santos<herbert.aga@gmail.com>
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     * @author   Herbert Santos<herbert.aga@gmail.com>
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     * @author   Herbert Santos<herbert.aga@gmail.com>
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Returns all deposits made by the user
     * @author   Herbert Santos<herbert.aga@gmail.com>
     * @return App\Models\Deposits
     */
    public function deposits(){
        return $this->hasMany(Deposits::class,'user_id');
    }

    /**
     * Returns all deposits authorized by the user
     * @author   Herbert Santos<herbert.aga@gmail.com>
     * @return App\Models\Deposits
     */
    public function depositsAuthorized(){
        return $this->hasMany(Deposits::class,'user_id')->where('authorized','1');
    }

    /**
     * Update Balance
     * @author   Herbert Santos<herbert.aga@gmail.com>
     * @param  float amount
     * @return void
     */
    public function updateClientBalance($amount,$type = "D")
    {
       $this->balance = $type == "D" ? $this->balance - $amount :  $this->balance + $amount;
       $this->save();
    }

    public function insertLogBalance($amount,$type,$id){

        $log = new LogBalance();
        $log->type = $type;
        $log->amount = $amount;
        $log->previous_balance = $this->balance;
        $log->new_balance      = $type == "C" ? $this->balance + $amount : $this->balance - $amount;
        $log->user_id          = $this->id;

        if($type == "D"){
            $log->buy_id = $id;
        }else{
            $log->deposit_id = $id;
        }

        $log->save();

    }

    public function purchase(){
        return $this->hasMany(Buys::class,'user_id');
    }

    
}
