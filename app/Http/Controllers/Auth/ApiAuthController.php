<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiAuthController extends Controller
{
    public function register (UserRegisterRequest $request)
    {
        $request['password']= Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $user = User::create($request->toArray());
        $response['token'] = $user->createToken($request['email'])->accessToken;
        $response['user'] = $user;
        return Response::ok(true,'json',$response);
    }
    public function login (UserLoginRequest $request) {

        $user = User::where('email', $request['email'])->first();
        return $user ? Response::ok(true,'json',['token' => $user->createToken($request->email)->accessToken]) : Response::notFound();
    }
}
