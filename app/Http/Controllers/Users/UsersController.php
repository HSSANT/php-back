<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserSaveRequest;
use App\Models\User;
use App\Services\UsersService;
use Tymon\JWTAuth\Facades\JWTAuth;
class UsersController extends Controller
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UsersService();
    }

    public function accountStore(UserSaveRequest $request, User $user){
        $user->fill($request->all());
        $user = $this->userService->create($user);

        $credentials = ['email' => $user->email, 'password' => $request->password];
        
        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => true, 'message' => 'Unauthorized'], 200);
        }

        return AuthController::respondWithTokenStatic($token);

    }

}
