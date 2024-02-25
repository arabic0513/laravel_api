<?php

use App\Http\Controllers\UserController;
use App\Models\User;
use App\Traits\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::any('/download/excel',[UserController::class, 'exportExcel'])->name('excel.download');

Route::any('/download/pdf',[UserController::class, 'exportPdf'])->name('pdf.download');
