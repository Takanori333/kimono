<?php

namespace App\Http\Controllers;

use App\Functions\StylistFunction;
use Illuminate\Http\Request;

class StylistController extends Controller
{
    //スタイリスト一覧の画面
    function top(Request &$request){
        $s_function = new StylistFunction;
        $stylist_list = $s_function->top($request);
        return view('stylist.top',['stylist_list'=>$stylist_list]);
    }

    //TODO:notfound画面
    //予約画面
    function reserve($reserve_id){
        $s_function = new StylistFunction();
        $reserve = $s_function->reserve($reserve_id);
        if($reserve!==false){
            return view('stylist.book',compact('reserve'));
        }
    }
    //TODO:感謝画面
    //予約を決定する
    function confirm(Request &$request){
        $s_function = new StylistFunction();
        $s_function->confirm($request);
    }
}
