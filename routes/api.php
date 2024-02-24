<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['cors', 'json.response']], function () {

    Route::post('/register',[ApiAuthController::class, 'register'])->name('register.api');
    Route::post('/login', [ApiAuthController::class, 'login'])->name('login.api');
    Route::post('/logout', [ApiAuthController::class, 'logout'])->name('logout.api');
});

Route::get('/my-info',[UserController::class, 'my_info'])->name('my-info');
Route::post('/user-create',[ApiAuthController::class, 'register'])->middleware('is_admin')->name('user-create');
Route::post('/user-edit',[UserController::class, 'user_edit'])->middleware('is_admin')->name('user-edit');
Route::post('/user-delete',[UserController::class, 'user_delete'])->middleware('is_super_admin')->name('user-delete');
Route::get('/all-admins',[UserController::class, 'all_admins'])->middleware('is_super_admin')->name('all-admins');
Route::get('/all-users',[UserController::class, 'all_users'])->middleware('is_admin')->name('all-users');
Route::post('/admin-create',[UserController::class, 'admin_create'])->middleware('is_super_admin')->name('admin-create');
Route::post('/admin-edit',[UserController::class, 'user_edit'])->middleware('is_super_admin')->name('admin-edit');
Route::post('/admin-delete',[UserController::class, 'user_delete'])->middleware('is_super_admin')->name('admin-delete');
