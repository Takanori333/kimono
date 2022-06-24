<?php
    namespace App\Functions;

    use App\Models\Item_chat;
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
            DB::table('stylist_chats')->where('stylist_id','=',$request->stylist_id)
            ->where('customer_id','=',$request->customer_id)->where('from','=',(int)$request->from==0?1:0)->update(['readed'=>0]);
        }
        //スタイリストの顧客一覧を戻す
        function stylist_customer_list(){
            $stylist = unserialize(session()->get("stylist"));
            $stylist_id = $stylist->getId();
            // $stylist_id = 9999999;
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
            $stylist = unserialize(session()->get("stylist"));
            $stylist_id = $stylist->getId();
            // $stylist_id = 9999999;            
            $message_list = DB::table('stylist_chats')->where('stylist_id','=',$stylist_id)->where('customer_id','=',$request->customer_id)->get();
            DB::table('stylist_chats')->where('stylist_id','=',$stylist_id)
            ->where('customer_id','=',$request->customer_id)->where('from','=',1)->update(['readed'=>0]);
            return $message_list;
        }
        //スタイリスト顧客が選択したスタイリストのメッセージを取得する
        function stylist_customer_get_message($id){
            $user = unserialize(session()->get("user"));
            $user_id = $user->id;
            // $user_id = 9999999;
            $message_list = DB::table('stylist_chats')->where('stylist_id','=',$id)->where('customer_id','=',$user_id)->get();
            DB::table('stylist_chats')->where('customer_id','=',$user_id)->where('stylist_id','=',$id)->where('from','=',0)->update(['readed'=>0]);
            return $message_list;            
        }
        //スタイリスト顧客が選択したスタイリストの情報を取得する
        function stylist_customer_get_info($id){
            $user = unserialize(session()->get("user"));
            $user_id = $user->id;
            // $user_id = 9999999;
            $stylist_info = DB::table('stylist_infos')->where('id','=',$id)->first();
            return $stylist_info;
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
            if($user){
                $user_id = $user->id;
                //もしユーザがurlのitem_idに対応する商品の販売者か購入者じゃないと、チャットがない画面にいく
                $seller_id = DB::table('items')->where('id','=',$item_id)->value('user_id');            
                $buyer_id = DB::table('item_histories')->where('item_id','=',$item_id)->value('buyer_id');
                $other_id = $user_id!=$seller_id?$seller_id:$buyer_id;
                $item_name = DB::table('item_infos')->where('id','=',$item_id)->value('name');
                if($seller_id==$user_id||$buyer_id==$user_id){
                    $message_list = DB::table('item_chats')->where('item_id','=',$item_id)->get();
                    $buyer_info = DB::table('user_infos')->where('id','=',$buyer_id)->first();
                    $seller_info = DB::table('user_infos')->where('id','=',$seller_id)->first();
                    $status = DB::table('trade_statuses')->where('item_id','=',$item_id)->value('status');
                    //メッセージを既読にする
                    DB::table('item_chats')->where('from','=',$other_id)->update(['readed'=>0]);
                    return [$message_list,$buyer_info,$seller_info,$status,$item_name];
                }    
            }
            return false;
        }
        //フリーマチャットからのメッセージをデータベースに挿入する
        function insert_item_chats(Request &$request){
            $item_chat = new Item_chat();
            $item_chat->item_id = $request->item_id;
            $item_chat->text = $request->message;
            $item_chat->from = $request->from;            
            $item_chat->save();
            DB::table('item_chats')->where('item_id','=',$request->item_id)->where('from','<>',$request->from)->update(['readed'=>"0"]);
        }
        //取引ステージの情報を変更する
        function change_trade_status(Request $request){
            $status = DB::table('trade_statuses')->where('item_id','=',$request->id)->value('status');
            $status = (int)$status + 1;
            DB::table('trade_statuses')->where('item_id','=',$request->id)->update(
                ['status'=>$status]
            );
        }
        //ユーザーに新しいメッセージは入っているかどうかを監視する
        function user_listen_chat(){
            $user = unserialize(session()->get("user"));
            $user_id = $user->id;
            $items = [];
            $sell_item = DB::table('items')->where('user_id','=',$user_id)->pluck('id');
            foreach($sell_item as $id){
                $items[] = $id;
            }
            $buy_item = DB::table('item_histories')->where('buyer_id','=',$user_id)->pluck('item_id');
            foreach($buy_item as $id){
                $items[] = $id;
            }
            $items = array_unique($items);
            $chat_count = DB::table('item_chats')->whereIn('item_id',$items)->where('from','<>',$user_id)->sum('readed');
            $chat_count += DB::table('stylist_chats')->where('customer_id','=',$user_id)->where('from','=',0)->sum('readed');
            // session(['chat'=>$count]);
            return $chat_count;
        }
        //ユーザーのチャット一覧
        function user_chat_list(){
            $user = unserialize(session()->get("user"));
            $user_id = $user->id;
            $sell_items = [];
            $sell_item = DB::table('items')->where('user_id','=',$user_id)->pluck('id');
            foreach($sell_item as $id){
                $sell_items[] = $id;
            }
            $buy_items = [];
            $buy_item = DB::table('item_histories')->where('buyer_id','=',$user_id)->pluck('item_id');
            foreach($buy_item as $id){
                $buy_items[] = $id;
            }
            $items = array_merge($sell_items,$buy_items);
            $items_name = DB::table('item_infos')->select('id','name')->whereIn('id',$items);
            $last_message_other = DB::table('item_chats')->
            select('from','item_id',DB::raw('SUM(readed) as readed,MAX(created_at) as last_message'))
            ->whereIn('item_id',$items)->where('from','<>',$user_id)->orderBy('last_message','desc')
            ->groupBy('from')->groupBy('item_id');

            $chat_other_list = DB::table('user_infos')->
            select('user_infos.name','user_infos.icon','user_infos.id','chat.last_message','chat.readed','chat.item_id','names.name as item_name')
            ->joinSub($last_message_other,'chat',function($join){
                $join->on('user_infos.id','=','chat.from');
            })->joinSub($items_name,'names',function($join){
                $join->on('chat.item_id','=','names.id');
            })->get();

            $last_message_stylist = DB::table('stylist_chats')->
            select('stylist_id',DB::raw('SUM(readed) as readed,MAX(created_at) as last_message'))
            ->where('customer_id','=',$user_id)->where('from','=','0')->orderBy('last_message','desc')->
            groupBy('stylist_id');

            $stylist_list = DB::table('stylist_infos')->
            select('stylist_infos.name','stylist_infos.icon','stylist_infos.id','stylist.last_message','stylist.readed')
            ->joinSub($last_message_stylist,'stylist',function($join){
                $join->on('stylist_infos.id','=','stylist.stylist_id');
            })->get();

            return [$chat_other_list,$stylist_list];
        }

        //スタイリストに新しいメッセージは入っているかどうかを監視する
        function stylist_user_listen_chat(){
            $stylist = unserialize(session()->get("stylist"));
            $stylist_id = $stylist->getId();
            $chat_count = DB::table('stylist_chats')->where('stylist_id','=',$stylist_id)->where('from','=',1)->sum('readed');
            // session(['chat'=>$count]);
            return $chat_count;
        }
    }