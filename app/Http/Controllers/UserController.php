<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index():JsonResponse
    {
        $users = User::all();
        return response()->json(['users'=>$users, 'message'=>'butun userler getirildi'],200);
    }

    public function store(UserCreateRequest $request):JsonResponse
    {
        $user = User::create(array_merge($request->all(), ['api_token' => Str::random(60)]));
        return response()->json([

            'user'=>$user,
        ]);
    }
    public function show(User $user)
    {
        return response()->json([
            'user' => $user,
            'api_token' => $user->api_token,
        ]);
    }

    public function update(UserUpdateRequest $request, User $user): JsonResponse
    {
        $user->update($request->all());

        return response()->json([
            'request' => $request->all(),
            'user' => $user,
            'message' => 'User updated successfully',
        ]);
    }
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'user' => $user,
            'message' => 'User deleted successfully',
        ]);
    }
}
