<?php
    namespace App\Functions;

    use App\Classes\Stylist;
    use App\Models\Stylist as StylistDB;
    use App\Models\Stylist_info;
    use App\Models\Stylist_area;
    use App\Models\Stylist_service;
    use App\Models\Stylist_freetime;
    use App\Models\Stylist_chat;
    use Illuminate\Http\Request;
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\DB;
    
    class ChatFunction{
        function __construct()
        {
            
        }
        //スタイリストチャットのメッセージをデータベースに挿入する
        function insert_stylist(Request &$request){
            $stylist_chat = new Stylist_chat();
            $stylist_chat->stylist_id = $request->stylist_id;
            $stylist_chat->customer_id = $request->customer_id;
            $stylist_chat->text = $request->message;
            $stylist_chat->from = $request->from;
            $stylist_chat->save();
        }

        function stylist_customer_list(){
            // $stylist = unserialize(session()->get("stylist"));
            // $stylist_id = $stylist->getId();
            $stylist_id = 9999999;

            // $customer_list = DB::table('stylist_chats')->select('user_infos.name','user_infos.icon','user_infos.id','stylist_chats.created_at')
            // ->where('stylist_chats.stylist_id','=',$stylist_id)
            // ->leftJoin('user_infos','stylist_chats.customer_id','=','user_infos.id')
            // ->latest('stylist_chats.created_at')->distinct()->get();

            $last_message_customer = DB::table('stylist_chats')->
            select('customer_id',DB::raw('MAX(created_at) as last_message'))
            ->where('stylist_id','=',$stylist_id)->orderBy('last_message','desc')->
            groupBy('customer_id');

            $customer_list = DB::table('user_infos')->
            select('user_infos.name','user_infos.icon','user_infos.id','customers.last_message')
            ->joinSub($last_message_customer,'customers',function($join){
                $join->on('user_infos.id','=','customers.customer_id');
            })->get();

            return $customer_list;
        }
        //スタイリストが選択した顧客とのメッセージを取得する
        function stylist_user_get_message($id){
            // $stylist = unserialize(session()->get("stylist"));
            // $stylist_id = $stylist->getId();
            $stylist_id = 9999999;
            $message_list = DB::table('stylist_chats')->where('stylist_id','=',$stylist_id)->where('customer_id','=',$id)->get();
            return $message_list;
        }
    }