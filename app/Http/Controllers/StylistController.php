<?php

namespace App\Http\Controllers;

use App\Functions\StylistFunction;
use Illuminate\Http\Request;

class StylistController extends Controller
{
    //スタイリスト一覧の画面
    function top(Request &$request){
        $s_function = new StylistFunction();
        $stylist_list = $s_function->top($request);
        return view('stylist.top',['stylist_list'=>$stylist_list,'area'=>$request->area,'service'=>$request->service,'sort'=>$request->sort,'stylist_name'=>$request->stylist_name]);
    }
    //スタイリスト情報
    function stylist_info($id){
        $s_function = new StylistFunction();
        $info = $s_function->stylist_info($id);
        return view('stylist.show',["stylist"=>$info[0],"services"=>$info[1],"areas"=>$info[2],"freetime"=>$info[3],"is_follow"=>$info[4],"follower_count"=>$info[5],"comments"=>$info[6]]);
    }

    //予約画面
    function reserve($reserve_id){
        $s_function = new StylistFunction();
        $reserve = $s_function->reserve($reserve_id);
        if($reserve!==false){
            return view('stylist.book',compact('reserve'));
        }
        return redirect(asset('/notfound'));
    }
    //予約を決定する
    function confirm(Request &$request){
        $s_function = new StylistFunction();
        $s_function->confirm($request);
        return redirect(asset('/thanks'));
    }

    function follow(Request &$request){
        $s_function = new StylistFunction();
        $s_function->follow($request);
        return redirect(asset("/stylist/show/".$request->id));
    }
    function unfollow(Request &$request){
        $s_function = new StylistFunction();
        $s_function->unfollow($request);
        return redirect(asset("/stylist/show/".$request->id));
    }

}
