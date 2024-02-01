<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Js;
use Illuminate\View\View;


class AuthController extends Controller
{

    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request):JsonResponse
    {
        $user = User::create($request->all());
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token,
        ],201);
    }

    public function login(LoginRequest $request):JsonResponse
    {
        $credentials = $request->safe()->only(['email', 'password']);


        if (auth()->attempt($credentials)) {
            $user = User::where('email', $request->email)->first();
            $user->token = $user->createToken('authToken')->plainTextToken;

            return response()->
            json(
                [
                    "message"=>"ugurla girish edildi",
                    "user"=>$user,
                    "token"  =>$user->token
                    ],200);
        }

        return response()->json(["message"=>"duzgun giris edilmedi"],200);
    }
    public function iam(Request $request){
        $user = $request->user();
        return response()->json([
            'name'=>$user->name,
            'access_token'=>$user->access_token,
        ]);
    }
}
