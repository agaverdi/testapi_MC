<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next):JsonResponse
    {
        $auth = $request->header('Authorization');
        if ($auth){
            $token = str_replace('Bearer ','',$auth);

            if (!$token){
                return response()->json([
                    'message'=>'No Bearer token'
                ],401);
            }
            $user = User::where('api_token',$token)->first();
            if (!$user){
                return response()->json([
                   'message'=>'Invalid Bearer Token! '
                ],401);
            }
            auth()->setUser($user);
            return $next($request);
        }
        return response()->json([
            'message'=>'Not a valid Bearer token'
        ],401);
    }
}
