<?php

namespace App\Services;


use App\Models\LogBalance;
use Illuminate\Validation\ValidationException;


class LogBalanceService
{
   /**
     * Create a new Service instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Create a new Buy
     *
     * @param App\Models\Buys $buy
     */
    public function listAlterBalance()
    {
        if(auth()->user()->hasRole('client')){

            $list = LogBalance::with(['user','buy','deposit'])->where('user_id',auth()->user()->id)->get();
            return $list;

        }else{
            throw ValidationException::withMessages(['Access not allowed']);
        }

    }




}
