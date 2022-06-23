<?php

namespace App\Http\Controllers\Deposits;

use App\Http\Controllers\Controller;
use App\Http\Requests\Deposits\DepositAlterStatusRequest;
use App\Http\Requests\Deposits\DepositStoreRequest;
use App\Http\Requests\Deposits\DepositFilteredRequest;
use App\Models\Deposits;
use App\Services\DepositsService;
use App\Services\LogBalanceService;
use Illuminate\Support\Facades\Log;

class DepositController extends Controller
{

    private $depositService;
    private $logBalanceService;

    public function __construct()
    {
        $this->depositService = new DepositsService();
        $this->logBalanceService = new LogBalanceService();
    }

    public function storeDeposit(DepositStoreRequest $request, Deposits $deposit){
        Log::channel('stderr')->info('store deposit!!');
        $deposit = $this->depositService->makeDeposit($deposit,$request);
        return response()->json($deposit);
    }

    public function listPending(){
        $listDeposit = $this->depositService->listDepositPending();
        return response()->json($listDeposit);
    }
    public function listFiltered(DepositFilteredRequest $request){
        $listDeposit = $this->depositService->listDepositFiltered($request);
        return response()->json($listDeposit);
    }

    public function alterStatusDeposit(DepositAlterStatusRequest $request){
        return $this->depositService->alterStatus($request);
    }

    public function listLogBalance(){
        return $this->logBalanceService->listAlterBalance();
    }

    public function depositDetails($id){
        return $this->depositService->getDetails($id);
    }
}
