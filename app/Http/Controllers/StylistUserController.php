<?php

namespace App\Http\Controllers;

use App\Functions\ChatFunction;
use App\Functions\StylistUserFunction;
use App\Http\Requests\StylistSignInRequest;
use App\Http\Requests\StylistSignUpRequest;
use App\Http\Requests\StylistUpRequest;
use Illuminate\Http\Request;

class StylistUserController extends Controller
{
    //サインアップ
    function signup(StylistSignUpRequest &$request){
        $s_function = new StylistUserFunction();
        $s_function->signup($request);
        return redirect(asset('/stylist_user/signin'));
    }
    //サインイン
    function signin(StylistSignInRequest &$request){
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
        $stylist = unserialize(session()->get("stylist"));
        if($stylist){
            $s_function = new StylistUserFunction();
            $service_area = $s_function->get_service_area();
            $service = $s_function->get_service_menu();
            return view('stylist_user.info',["service_area"=>$service_area,"service"=>$service]);    
        }
        return redirect(asset('/stylist_user/signin'));
    }
    //スタイリストの情報を更新する
    function info_update(StylistUpRequest &$request){
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
        $stylist = unserialize(session()->get("stylist"));
        if($stylist){
            $s_function = new StylistUserFunction();
            $info_list = $s_function->top();
            return view('stylist_user.top',["reserve_list"=>$info_list[0],"freetime"=>$info_list[1],"status"=>$info_list[2],"follower_count"=>$info_list[3]]);
        }
        return redirect(asset('/stylist_user/signin'));
    }
    //予約詳細
    function reserve_detail($id){
        $stylist = unserialize(session()->get("stylist"));
        if($stylist){
            $s_function = new StylistUserFunction();
            $reserve = $s_function->reserve_detail($id);
            return view('stylist_user.reserve_detail',["reserve"=>$reserve]);
        }
        return redirect(asset('/stylist_user/signin'));
    }
    //活動履歴
    function reserve(){
        $stylist = unserialize(session()->get("stylist"));
        if($stylist){
            $s_function = new StylistUserFunction();
            $reserve_list = $s_function->reserve();
            return view('stylist_user.reserve',["reserve_list"=>$reserve_list]);
        }
        return redirect(asset('/stylist_user/signin'));            
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
    //スタイリストユーザーのチャット画面
    function chat(){
        $stylist = unserialize(session()->get("stylist"));
        if($stylist){
            $chat_f = new ChatFunction();
            $customer_list = $chat_f->stylist_customer_list();
            $stylist_f = new StylistUserFunction();
            $service = $stylist_f->get_service_menu();
            // var_dump($customer_list);
            return view('stylist_user.chat',['customer_list'=>$customer_list,'service'=>$service]);
        }
        return redirect(asset('/stylist_user/signin'));            
    }
    //スタイリストユーザーの一覧を取得する
    function get_customer(){
        $chat_f = new ChatFunction();
        $customer_list = $chat_f->stylist_customer_list();
        return $customer_list;
    }

}
