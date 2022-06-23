<?php

namespace App\Services;

use App\Models\Deposits;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;

class DepositsService
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
     * Create a new Deposit
     *
     * @param App\Models\Deposit $deposit
     */
    public function makeDeposit($deposit,$request)
    {
        Log::channel('stderr')->info('make deposit');
        Log::channel('stderr')->info(auth()->user());
        if(auth()->user()->hasRole('client')){
            $result = $request->all();
            Log::channel('stderr')->info('succcess');
            if($result['checkbook_image']){
                $folderPath = storage_path("/images/users/"); //path location
                $image_parts = explode(";base64,", $result['checkbook_image']);
                Log::channel('stderr')->info('explode');
                $image_type_aux = explode("image/", $image_parts[0]);
                Log::channel('stderr')->info('imagetype');
                $image_type = $image_type_aux[1];
                Log::channel('stderr')->info('imagebase64');
                $image_base64 = base64_decode($image_parts[1]);
                Log::channel('stderr')->info('uniqid');
                $uniqid = uniqid();
                Log::channel('stderr')->info('file');
                Log::channel('stderr')->info($uniqid);
                $file = $folderPath . $uniqid . '.'.$image_type;
                Log::channel('stderr')->info('file put contents');
                file_put_contents($file, $image_base64);
                
                Log::channel('stderr')->info('check image');
                Log::channel('stderr')->info($file);
                Log::channel('stderr')->info('set result checkbook image');
                $result['checkbook_image'] = $file;
            }
            Log::channel('stderr')->info('fill');
            $deposit->fill($result);
            Log::channel('stderr')->info('save');
            $deposit->save();

            return $deposit;

        }else{
            throw ValidationException::withMessages(['Access not allowed']) ;
        }

    }

    /**
     * Returns a list of pending deposits
     *
     * @return App\Models\Deposit $listDeposit
     */
    public function listDepositPending(){
        Log::channel('stderr')->info(auth()->user());
        if(auth()->user()->hasRole('administrator')){
            Log::channel('stderr')->info('inside if');
            return Deposits::where('authorized',null)->with('user')->get();

        }else{
            throw ValidationException::withMessages(['Access not allowed']);
        }

    }

    public function listDepositFiltered($request){
        Log::channel('stderr')->info('list deposit filtered line 90');
        Log::channel('stderr')->info($request->date);
        Log::channel('stderr')->info($request->userId);
        //return Deposits::where('user_id',$request->userId)->whereRaw('CONVERT(created_at,DATE)','>=',$request->date)->get();
        return Deposits::where('user_id',$request->userId)->whereDate('created_at',$request->date)->with('user')->get();
    }

    /**
     * Changes the status of the deposit
     *
     * @return App\Models\Deposit $deposit
     */
    public function alterStatus($request){

        if(auth()->user()->hasRole('administrator')){
            Log::channel('stderr')->info('alterstatus');
            Log::channel('stderr')->info($request->authorized);
            $deposit = Deposits::find($request->id);
            if(!$deposit){

                return response()->json(array(
                    'errors' => array(
                        ["Deposit not found"]
                    ),
                    "errCode" => 404
                ),404);

            }else{

                if($deposit->authorized_by != null){
                    if($deposit->authorized)
                        throw ValidationException::withMessages(['This deposit has already been approved or disapproved.']);
                    else
                        throw ValidationException::withMessages(['This deposit has already been disapproved.']);

                }else{
                    $deposit->fill($request->all());
                    $deposit->authorized_by = auth()->user()->id;
                    $deposit->save();

                    if($request->authorized){

                        $user = User::find($deposit->user_id);
                        $user->updateClientBalance($deposit->amount,"C");
                        $user->insertLogBalance($deposit->amount,"C",$deposit->id);

                        return response()->json(['success' => true],201);
                    }

                    return response()->json(['success' => true],201);
                }

            }

        }else{
            throw ValidationException::withMessages(['Access not allowed']);
        }

    }

    public function getDetails($id){
        if(auth()->user()->hasRole('administrator')){

            return Deposits::where('id',$id)->with('user')->first();

        }else{
            throw ValidationException::withMessages(['Access not allowed']);
        }
    }




}
