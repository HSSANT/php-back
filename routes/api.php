<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    
});

Route::group([

    'middleware' => 'apiJwt:api',
    'prefix' => 'account'

], function ($router) {
    Route::post('Transaction/new','\App\Http\Controllers\Deposits\DepositController@storeDeposit')->name('account.store.deposit');
    Route::post('buy','\App\Http\Controllers\Buys\BuysController@buyStore')->name('buy.store');
    Route::get('Transaction/pending','\App\Http\Controllers\Deposits\DepositController@listPending')->name('deposit.pending');
    Route::post('Transaction/filtered','\App\Http\Controllers\Deposits\DepositController@listFiltered')->name('deposit.filtered');
    Route::post('Transaction/update','\App\Http\Controllers\Deposits\DepositController@alterStatusDeposit')->name('status.deposit');
    Route::get('deposit/list','\App\Http\Controllers\Deposits\DepositController@listLogBalance')->name('list.deposit');
    Route::get('deposit/details/{id}','\App\Http\Controllers\Deposits\DepositController@depositDetails')->name('deposit.details');
    Route::post('me', 'AuthController@me');

});


Route::post('Authentication/sign-up','\App\Http\Controllers\Users\UsersController@accountStore')->name('account.store');


Route::get('storage/{filename}', function ($filename)
{
    $path = storage_path('images/users/' . $filename);
    if (!File::exists($path)) {
        abort(500);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
});

