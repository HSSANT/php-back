<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\{TokenExpiredException, TokenInvalidException};
use Illuminate\Support\Facades\Log;

class apiProtectedRoute extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Log::channel('stderr')->info('handle!!');
        try {
            $user = JWTAuth::parseToken()->authenticate();
            Log::channel('stderr')->info('sucess!!');
            // dd($user);
        } catch (Exception $exception) {
            Log::channel('stderr')->info('exception!!');
            Log::channel('stderr')->info($exception);
            if ($exception instanceof TokenInvalidException){
                return response()->json(['status' => 'Token is Invalid'],403);
            }else if ($exception instanceof TokenExpiredException){
                return response()->json(['status' => 'Token is Expired'],403);
            }else{
                return response()->json(['status' => 'Authorization Token not found'],403);
            }
        }
        Log::channel('stderr')->info('user!!');
        Log::channel('stderr')->info($user);
        return $next($request);

    }
}
