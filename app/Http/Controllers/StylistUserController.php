<?php

namespace App\Http\Controllers;

use App\Functions\ChatFunction;
use App\Functions\StylistUserFunction;
use Illuminate\Http\Request;

class StylistUserController extends Controller
{
    //サインアップ
    function signup(Request &$request){
        $s_function = new StylistUserFunction();
        $s_function->signup($request);
        return redirect(asset('/stylist_user/signin'));
    }
    //サインイン
    function signin(Request &$request){
        $s_function = new StylistUserFunction();
        $s_function->signin($request);
        return redirect(asset('/stylist_user'));
    }
    //サインアウト
    function signout(){
        session()->forget('stylist');
        return redirect(asset('/stylist_user/signin'));
    }
    //情報編集
    function info(){
        $s_function = new StylistUserFunction();
        $service_area = $s_function->get_service_area();
        $service = $s_function->get_service_menu();
        return view('stylist_user.info',["service_area"=>$service_area,"service"=>$service]);

    }
    //スタイリストの情報を更新する
    function info_update(Request &$request){
        $s_function = new StylistUserFunction();
        $s_function->info_update($request);
        return redirect(asset('/stylist_user/info'));
    }
    //スタイリストの活動地域をデータベースに追加する
    function insert_area(Request &$request){
        $s_function = new StylistUserFunction();
        $s_function->insert_area($request);
    }
    //スタイリストの活動地域を削除する
    function delete_area(Request &$request){
        $s_function = new StylistUserFunction();
        $s_function->delete_area($request);
    }    
    //スタイリストの活動地域をデータベースに追加する
    function insert_service(Request &$request){
        $s_function = new StylistUserFunction();
        $s_function->insert_service($request);
    }
    //スタイリストの活動地域を削除する
    function delete_service(Request &$request){
        $s_function = new StylistUserFunction();
        $s_function->delete_service($request);
    }    
    //スタイリストのトップページ
    function top(){
        $s_function = new StylistUserFunction();
        $info_list = $s_function->top();
        return view('stylist_user.top',["reserve_list"=>$info_list[0],"freetime"=>$info_list[1],"status"=>$info_list[2]]);
    }
    //予約詳細
    function reserve_detail($id){
        $s_function = new StylistUserFunction();
        $reserve = $s_function->reserve_detail($id);
        return view('stylist_user.reserve_detail',["reserve"=>$reserve]);
    }
    //活動履歴
    function reserve(){
        $s_function = new StylistUserFunction();
        $reserve_list = $s_function->reserve();
        return view('stylist_user.reserve',["reserve_list"=>$reserve_list]);
    }
    //活動可能時間を追加
    function freetime_DB(Request &$request){
        $s_function = new StylistUserFunction();
        $s_function->freetime_DB($request);
    }
    //活動可能時間の削除
    function delete_freetime_DB(Request &$request){
        $s_function = new StylistUserFunction();
        $s_function->delete_freetime_DB($request);
    }
    //予約可能状態の切り替え
    function change_status(Request &$request){
        $s_function = new StylistUserFunction();
        $s_function->change_status($request);
    }    

    function chat(){
        $chat_f = new ChatFunction();
        $customer_list = $chat_f->stylist_customer_list();
        // var_dump($customer_list);
        return view('stylist_user.chat',compact('customer_list'));
    }

}
