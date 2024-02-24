<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
        return response(['status' => true,'type' => 'json','data' => $response], 200);
    }
    public function login (UserLoginRequest $request) {

        $user = User::where('email', $request['email'])->first();
        if ($user) {
            if (Hash::check($request['password'], $user->password)) {
                $token = $user->createToken($request->email)->accessToken;
                $response = ['token' => $token];
                return response(['status' => true,'type' => 'json','data' => $response], 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response(['status' => false,'type' => 'json','data' => $response], 422);
            }
        } else {
            $response = ["message" =>'User does not exist'];
            return response(['status' => false,'type' => 'json','data' => $response], 422);
        }
    }
}
