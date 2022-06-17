<?php
    namespace App\Functions;

    use App\Classes\Stylist;
    use App\Models\Item_chat;
    use App\Models\Stylist as StylistDB;
    use App\Models\Stylist_info;
    use App\Models\Stylist_area;
    use App\Models\Stylist_service;
    use App\Models\Stylist_freetime;
    use App\Models\Stylist_chat;
    use App\Models\Stylist_reserve;
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
        //スタイリストの顧客一覧を戻す
        function stylist_customer_list(){
            // $stylist = unserialize(session()->get("stylist"));
            // $stylist_id = $stylist->getId();
            $stylist_id = 9999999;
            $last_message_customer = DB::table('stylist_chats')->
            select('customer_id',DB::raw('SUM(readed) as readed,MAX(created_at) as last_message'))
            ->where('stylist_id','=',$stylist_id)->where('from','=',1)->orderBy('last_message','desc')->
            groupBy('customer_id');

            $customer_list = DB::table('user_infos')->
            select('user_infos.name','user_infos.icon','user_infos.id','customers.last_message','customers.readed')
            ->joinSub($last_message_customer,'customers',function($join){
                $join->on('user_infos.id','=','customers.customer_id');
            })->get();

            return $customer_list;
        }
        //スタイリストが選択した顧客とのメッセージを取得する
        function stylist_user_get_message(Request &$request){
            // $stylist = unserialize(session()->get("stylist"));
            // $stylist_id = $stylist->getId();
            $stylist_id = 9999999;            
            $message_list = DB::table('stylist_chats')->where('stylist_id','=',$stylist_id)->where('customer_id','=',$request->customer_id)->get();
            DB::table('stylist_chats')->where('stylist_id','=',$stylist_id)
            ->where('customer_id','=',$request->customer_id)->where('from','=',1)->update(['readed'=>0]);
            return $message_list;
        }
        //スタイリスト顧客が選択したスタイリストのメッセージを取得する
        function stylist_customer_get_message($id){
            // $user = unserialize(session()->get("user"));
            // $user_id = $user->getId();
            $user_id = 9999999;
            $message_list = DB::table('stylist_chats')->where('stylist_id','=',$id)->where('customer_id','=',$user_id)->get();
            return $message_list;            
        }
        //スタイリストが予約を作る画面
        function make_reserve(Request &$request){
            $stylist_reserve = new Stylist_reserve();
            $uniqued_id = uniqid();
            $stylist_reserve->reserve_id = $uniqued_id;
            $stylist_reserve->stylist_id = $request->stylist_id;
            $stylist_reserve->customer_id = $request->customer_id;
            $stylist_reserve->price = $request->price;
            $stylist_reserve->services = $request->services;
            $stylist_reserve->start_time = Carbon::parse($request->start_time)->format('Y-m-d H:i:s');
            $stylist_reserve->end_time = Carbon::parse($request->end_time)->format('Y-m-d H:i:s');
            $stylist_reserve->save();
            return asset('/stylist/book/'.$uniqued_id);
        }
        //フリーマチャット
        function chat_trade($item_id){
            $user = unserialize(session()->get("user"));
            $user_id = $user->getId();
            //もしユーザがurlのitem_idに対応する商品の販売者か購入者じゃないと、チャットがない画面にいく
            $seller_id = DB::table('items')->where('id','=',$item_id)->value('user_id');            
            $buyer_id = DB::table('item_histories')->where('item_id','=',$item_id)->value('buyer_id');
            if($seller_id==$user_id||$buyer_id==$user_id){
                $message_list = DB::table('item_chats')->where('item_id','=',$item_id)->get();
                return $message_list;
            }
            return false;
        }
        //フリーマチャットからのメッセージをデータベースに挿入する
        function insert_item_chats(Request &$request){
            $item_chat = new Item_chat();
            $item_chat->item_id = $request->item_id;
            $item_chat->text = $request->text;
            $item_chat->from = $request->message;
            $item_chat->save();
        }
    }