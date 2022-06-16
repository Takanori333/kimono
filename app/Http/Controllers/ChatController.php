<?php

namespace App\Http\Controllers;

use App\Functions\ChatFunction;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    function insert_stylist(Request &$request){
        $chat_f = new ChatFunction();
        $chat_f->insert_stylist($request);
    }
}
