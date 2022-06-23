<?php

namespace App\Services;

use App\Models\Buys;
use Illuminate\Validation\ValidationException;


class BuysService
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
    public function makeBuy(Buys $buy,$request)
    {
        if(auth()->user()->hasRole('client')){

            $data            = $request->all();

            if(auth()->user()->balance >= $data['amount']){

                $data['user_id'] = auth()->user()->id;
                $buy->fill($data);
                $buy->save();

                $user = auth()->user();
                $user->updateClientBalance($data['amount']);
                $user->insertLogBalance($data['amount'],"D",$buy->id);

                return response()->json($buy);
                
            }else{
                return response()->json(['error' => true, 'message' => 'Insufficient funds']);
            }


        }else{
            return response()->json(['error' => true, 'message' => 'Access not allowed']);
        }

    }




}
