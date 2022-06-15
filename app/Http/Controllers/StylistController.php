<?php

namespace App\Http\Controllers;

use App\Functions\StylistFunction;
use Illuminate\Http\Request;

class StylistController extends Controller
{
    function top(Request &$request){
        $s_function = new StylistFunction;
        $stylist_list = $s_function->top($request);
        return view('stylist.top',['stylist_list'=>$stylist_list]);
    }
}
