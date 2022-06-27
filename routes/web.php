<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StylistUserController;
use App\Http\Controllers\StylistController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FleamarketController;
use App\Http\Controllers\ManagerController;

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
Route::post('/stylist_user/get_customer',[StylistUserController::class,'get_customer']);
//スタイリスト
Route::get('/stylist',[StylistController::class,'top']);
Route::get('/stylist/book/{reserve_id}',[StylistController::class,'reserve']);
Route::post('/stylist/confirm',[StylistController::class,'confirm']);
Route::get('/stylist/show/{id}',[StylistController::class,'stylist_info']);
Route::post('/stylist/follow',[StylistController::class,'follow']);
Route::post('/stylist/unfollow',[StylistController::class,'unfollow']);
// ユーザー
Route::get('/user/signin',[UserController::class,'signinIndex']);
Route::get('/user/signout',[UserController::class,'signout']);
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
Route::get('/user/order_detail/{id}',[UserController::class,'order_detail']);
Route::get('/user/assess_stylist',[UserController::class,'assessStylist']);
Route::get('/user/follower/{id}',[UserController::class,'followerIndex']);
Route::get('/user/follow/{id}',[UserController::class,'followIndex']);
Route::get('/user/follow_DB',[UserController::class,'follow']);
Route::get('/user/unfollow_DB',[UserController::class,'unfollow']);
Route::get('/user/stylist_follow_DB',[UserController::class,'stylistFollow']);
Route::get('/user/stylist_unfollow_DB',[UserController::class,'stylistUnfollow']);
Route::get('/user/edit/{id}',[UserController::class,'editIndex']);
Route::post('/user/edit_DB',[UserController::class,'editUser']);
Route::get('/user/show/{id}',[UserController::class,'showIndex']);
Route::get('/user/assessment/customer/{id}',[UserController::class,'getCustomerAssessment']);
Route::get('/user/assessment/seller/{id}',[UserController::class,'getSellerAssessment']);
Route::post('/user/assess_seller',[UserController::class,'assessSeller']);
Route::post('/user/assess_customer',[UserController::class,'assessCustomer']);
Route::get('/user/chat/',[UserController::class,'chat']);
Route::get('/user/stylist_chat/{id}',[UserController::class,'chat_stylist']);
Route::get('/user/trade_chat/{item_id}',[UserController::class,'chat_trade']);
Route::post('/change_trade_status/{item_id}',[ChatController::class,'change_trade_status']);
//チャット（データベースに保存）
Route::post('/chat/insert_stylist',[ChatController::class,'insert_stylist']);
Route::post('/chat/insert_trade',[ChatController::class,'insert_trade']);
Route::post('/chat/stylist_user_get_message',[ChatController::class,'stylist_user_get_message']);
Route::post('/make_reserve',[ChatController::class,'make_reserve']);

// フリマ関連
Route::get('/fleamarket', [FleamarketController::class, 'index'])->name('fleamarket');
Route::get('/fleamarket/exhibit/new', [FleamarketController::class, 'createIndex']);
Route::post('/fleamarket/exhibit/confirm', [FleamarketController::class, 'createConfirm']);
Route::post('/fleamarket/exhibit/done', [FleamarketController::class, 'create']);
Route::get('/fleamarket/edit/{id}', [FleamarketController::class, 'edit']);
Route::post('/fleamarket/edit/{id}', [FleamarketController::class, 'editConfirm']);
Route::post('/fleamarket/update/{id}', [FleamarketController::class, 'editDone']);
Route::get('/fleamarket/search', [FleamarketController::class, 'search']);
Route::get('/fleamarket/item/{id}', [FleamarketController::class, 'show']);
Route::post('/fleamarket/item/{id}/upload/comment', [FleamarketController::class, 'uploadComment']);
Route::get('/fleamarket/purchase/{id}', [FleamarketController::class, 'purchase']);
Route::post('/fleamarket/purchase/confirm/{id}', [FleamarketController::class, 'purchaseConfirm']);
Route::post('/fleamarket/purchase/done/{id}', [FleamarketController::class, 'purchaseDone']);
Route::post('/fleamarket/favorite/insert', [FleamarketController::class, 'insertFavorite']);
Route::post('/fleamarket/favorite/delete', [FleamarketController::class, 'deleteFavorite']);
Route::get('/fleamarket/favorite', [FleamarketController::class, 'showFavorites']);

// 管理者
Route::get('/manager',[ManagerController::class,'index']);
Route::get('/manager/signin',[ManagerController::class,'signinIndex']);
Route::post('/manager/signin_DB',[ManagerController::class,'signin']);
Route::get('/manager/signout',[ManagerController::class,'signout']);
Route::get('/manager/user',[ManagerController::class,'userManageIndex']);
Route::get('/manager/user/delete',[ManagerController::class,'deleteUser']);
Route::get('/manager/user/recover',[ManagerController::class,'recoverUser']);
Route::get('/manager/item',[ManagerController::class,'itemManageIndex']);
Route::get('/manager/item/delete',[ManagerController::class,'deleteItem']);
Route::get('/manager/item/recover',[ManagerController::class,'recoverItem']);
Route::get('/manager/stylist',[ManagerController::class,'stylistManageIndex']);
Route::get('/manager/stylist/history/{id}',[ManagerController::class,'stylist_history']);
Route::get('/manager/stylist/delete',[ManagerController::class,'deleteStylist']);
Route::get('/manager/stylist/recover',[ManagerController::class,'recoverStylist']);
Route::get('/manager/faq',[ManagerController::class,'faqManageIndex']);
Route::get('/manager/faq/edit/{id}',[ManagerController::class,'editFaqIndex']);
Route::get('/manager/faq/edit_DB',[ManagerController::class,'editFaq']);
Route::get('/manager/faq/create',[ManagerController::class,'createFaqIndex']);
Route::get('/manager/faq/create_DB',[ManagerController::class,'createFaq']);
Route::get('/manager/faq/delete',[ManagerController::class,'deleteFaq']);
Route::get('/manager/faq/recover',[ManagerController::class,'recoverFaq']);

//notfound
Route::get('/notfound',function () {
    return view('not_found');
});
//thanks
Route::get('/thanks',function () {
    return view('thanks');
});

Route::get('/faq',[UserController::class,'faq']);

