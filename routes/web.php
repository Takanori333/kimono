<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StylistUserController;
use App\Http\Controllers\StylistController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//スタイリストユーザ
Route::get('/stylist_user',[StylistUserController::class,'top']);
Route::get('/stylist_user/signin',function(){
    return view('stylist_user.signin');
});
Route::get('/stylist_user/signup',function(){
    return view('stylist_user.signup');
});
Route::get('/stylist_user/signout',[StylistUserController::class,'signout']);
Route::get('/stylist_user/info',[StylistUserController::class,'info']);
Route::get('/stylist_user/reserve',[StylistUserController::class,'reserve']);
Route::get('/stylist_user/reserve_detail/{id}',[StylistUserController::class,'reserve_detail']);
Route::post('/stylist_user/signup_DB',[StylistUserController::class,'signup']);
Route::post('/stylist_user/signin_DB',[StylistUserController::class,'signin']);
Route::post('/stylist_user/info_DB',[StylistUserController::class,'info_update']);
Route::post('/stylist_user/insert_area',[StylistUserController::class,'insert_area']);
Route::post('/stylist_user/delete_area',[StylistUserController::class,'delete_area']);
Route::post('/stylist_user/insert_service',[StylistUserController::class,'insert_service']);
Route::post('/stylist_user/delete_service',[StylistUserController::class,'delete_service']);
Route::post('/stylist_user/freetime_DB',[StylistUserController::class,'freetime_DB']);
Route::post('/stylist_user/delete_freetime_DB',[StylistUserController::class,'delete_freetime_DB']);
Route::post('/stylist_user/change_status',[StylistUserController::class,'change_status']);
//スタイリスト
Route::get('/stylist',[StylistController::class,'top']);
// ユーザー
Route::get('/user/signin',function(){
    return view('user.signin');
});
Route::get('/user/signin',[UserController::class,'signin_index']);

Route::get('/user/signup',function(){
    return view('user.signup');
});

Route::post('/user/signin_DB',[UserController::class,'signin']);
Route::post('/user/signup_DB',[UserController::class,'signup']);

Route::get('/user/info/{id}',[UserController::class,'info_index']);

