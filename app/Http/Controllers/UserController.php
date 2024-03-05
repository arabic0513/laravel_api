<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
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
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function exportExcel()
    {
        return Excel::download(new UserExport,'users.xlsx');
    }
    public function exportPdf()
    {
        $customPaper = array(0,0,720,1440);
        $pdf = PDF::loadView('pdf', ['users' => User::all()])->setPaper($customPaper, 'landscape');
        return $pdf->download('users.pdf');
    }
    public function my_info()
    {
        return Response::ok(true,'json',auth()->guard('api')->user());
    }
    public function admin_create(UserRegisterRequest $request)
    {
        $request['role_id'] = Role::Admin;
        $create = new ApiAuthController();
        return $create->register($request);
    }
    public function user_edit(UserEditRequest $request)
    {
        $user = DB::table('users')->where('id',$request->id)->update($request->toArray());
        return $user ? Response::ok(true,'json',$user) : Response::notFound();
    }
    public function user_delete(UserEditRequest $request)
    {
        $user = DB::table('users')->where('id',$request->id)->delete();
        return $user ? Response::deleted(true,'json') : Response::notFound();
    }
    public function all_admins()
    {
        $users = DB::table('users')->where('role_id', Role::Admin)->get();
        return $users ? Response::ok(true,'json',$users) : Response::notFound();
    }
    public function all_users()
    {
        $users = DB::table('users')->where('role_id', Role::User)->get();
        return $users ? Response::ok(true,'json',$users,true) : Response::notFound();
    }
}
