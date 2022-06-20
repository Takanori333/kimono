<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StylistUserController;
use App\Http\Controllers\StylistController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FleamarketController;

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
Route::get('/stylist_user/chat',[StylistUserController::class,'chat']);
//スタイリスト
Route::get('/stylist',[StylistController::class,'top']);
Route::get('/stylist/book/{reserve_id}',[StylistController::class,'reserve']);
Route::post('/stylist/confirm',[StylistController::class,'confirm']);
Route::get('/stylist/show/{id}',[StylistController::class,'stylist_info']);
// ユーザー
Route::get('/user/signin',[UserController::class,'signinIndex']);
Route::get('/user/signup',function(){
    return view('user.signup');
});
Route::post('/user/signin_DB',[UserController::class,'signin']);
Route::post('/user/signup_DB',[UserController::class,'signup']);
Route::get('/user/info/{id}',[UserController::class,'infoIndex']);
Route::get('/user/exhibited/{id}',[UserController::class,'exhibitedIndex']);
Route::get('/user/exhibited/delete/{id}',[UserController::class,'exhibited_delete']);
Route::get('/user/purchased/{id}',[UserController::class,'purchasedIndex']);
Route::get('/user/sold/{id}',[UserController::class,'soldIndex']);
Route::get('/user/ordered/{id}',[UserController::class,'orderedIndex']);
Route::get('/user/follower/{id}',[UserController::class,'followerIndex']);
Route::get('/user/follow/{id}',[UserController::class,'followIndex']);
Route::get('/user/follow_DB',[UserController::class,'follow']);
Route::get('/user/unfollow_DB',[UserController::class,'unfollow']);
Route::get('/user/edit/{id}',[UserController::class,'editIndex']);
Route::post('/user/edit_DB',[UserController::class,'editUser']);
Route::get('/user/show/{id}',[UserController::class,'showIndex']);

Route::get('/user/stylist_chat/{id}',[UserController::class,'chat_stylist']);
Route::get('/user/trade_chat/{item_id}',[UserController::class,'chat_trade']);
//チャット（データベースに保存）
Route::post('/chat/insert_stylist',[ChatController::class,'insert_stylist']);
Route::post('/chat/stylist_user_get_message',[ChatController::class,'stylist_user_get_message']);
Route::post('/make_reserve',[ChatController::class,'make_reserve']);

// フリマ関連
Route::get('/fleamarket', [FleamarketController::class, 'index']);
Route::get('/fleamarket/exhibit/new', [FleamarketController::class, 'createIndex']);
Route::post('/fleamarket/exhibit/confirm', [FleamarketController::class, 'createConfirm']);
Route::post('/fleamarket/exhibit/done', [FleamarketController::class, 'create']);

