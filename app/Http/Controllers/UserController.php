<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Requests\UserEditRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use App\Traits\Role;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Passport\AuthCode;
use App\PDFGenerate;

class UserController extends Controller
{
    public function my_info()
    {
        return response(['status' => true,'type' => 'json','data' => auth()->guard('api')->user()],200);
    }
    public function admin_create(UserRegisterRequest $request)
    {
        $request['role_id'] = Role::Admin;
        $create = new ApiAuthController();
        return $create->register($request);
    }
    public function user_edit(UserEditRequest $request)
    {
        DB::table('users')->where('id',$request->id)->update($request->toArray());
        return response(['status' => true,'type' => 'json','data' => $request], 200);
    }
    public function user_delete(UserEditRequest $request)
    {
        DB::table('users')->where('id',$request->id)->delete();
        return response(['status' => true,'type' => 'json','message' => 'User deleted']);
    }
    public function all_admins()
    {
        return response(['status' => true,'type' => 'json','data' => User::where('role_id', Role::Admin)->get()]);
    }
    public function all_users()
    {
        $users = DB::table('users')->where('role_id', Role::User)->get();
        return response(['status' => true,'type' => 'json','data' => $users]);
    }
}
