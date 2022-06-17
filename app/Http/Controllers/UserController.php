<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\User_info;
use App\Models\User_follower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Functions\ChatFunction;
use App\Models\Item;
use App\Models\Item_history;
use App\Models\Stylist_history;

class UserController extends Controller
{
    // サインイン画面の表示
    public function signin_index(Request $request)
    {
        // msgの初期値
        $data = [
            "msg" => "",
        ];

        // リダイレクト時のmsgの代入
        // emailとpasswordの組み合わせが違う時のエラーメッセージが入る
        if ($request->old("msg")) {
            $data["msg"] = $request->old("msg");
        }

        return view("user.signin", $data);
    }

    // サインインの処理
    public function signin(Request $request)
    {
        // バリデーションチェック

        // 入力値の代入
        $input_email = $request->email;
        $input_password = $request->password;

        // 入力されたemailに一致するものをusersから取り出す
        $user = User::where("email", $input_email)->first();

        // flgの初期値
        $flg = true;

        // 入力されたemailに一致するものがあったときの処理
        // なかったときは$userにNULLが入る
        if ($user) {
            if ($input_password == $user->password) {
                // セッションにuserのインスタンスを格納
                $request->session()->put("user", serialize($user));

                // フリマトップページにリダイレクト
                // return redirect("/fleamarket ");

                // 今は、フリマトップページができていないので、ユーザー情報画面にリダイレクト
                return redirect("user/info/$user->id");
            } else {
                // emailとpasswordの組み合わせが正しくないときは、flgにfalseを代入
                $flg = false;
            }
        } else {
            $flg = false;
        }

        // emailとpasswordの組み合わせが正しくないとき
        // サインイン画面にリダイレクト
        if (!$flg) {
            return redirect("user/signin")->withInput(["msg" => "メールアドレスまたはパスワードが違います"]);
        }
    }

    // サインアップの処理
    public function signup(Request $request)
    {
        // バリデーションチェック

        $user = new User();
        $user_info = new User_info();

        // usersに保存する値
        $user_form = [
            "email" => $request->email,
            "password" => $request->password,
        ];

        // user_infosに保存する値
        $user_info_form = [
            "name" => $request->name,
            "address" => $request->address,
            "sex" => $request->sex,
            // heightはnullable
            "height" => $request->height,
            "phone" => $request->phone,
            "post" => $request->post,
            "birthday" => $request->year . "-" . $request->month . "-" . $request->day,
        ];

        // DBに保存
        $user->fill($user_form)->save();
        $user_info->fill($user_info_form)->save();

        // 登録したユーザーのidを代入
        $user = User::where("email", $request->email)->first();

        // セッションにuserのインスタンスを格納
        $request->session()->put("user", serialize($user));

        // フリマトップページへリダイレクト
        // return redirect("/fleamarket ");

        // 今は、フリマトップページができていないので、ユーザー情報画面にリダイレクト
        return redirect("user/info/$user->id");
    }

    // ユーザー情報ページの表示
    public function info_index(Request $request)
    {
        // $id = $request->id;
        // 該当のidのユーザー情報をDBから取り出す
        // $user = User::with("user_info")
        //             ->where("users.id", $id)
        //             ->first();

        $user = unserialize($request->session()->get("user"));
        // var_dump($user);

        //  平均評価を計算し、代入
        $average_seller_point = $user->getAverageSellerPoint();
        $average_customer_point = $user->getAverageCustomerPoint();

        // フォロー数とフォロワー数を計算
        $follower_count = User_follower::where("follow_id", $user->id)->count();
        $follow_count = User_follower::where("follower_id", $user->id)->count();

        $data = [
            "user" => $user,
            "average_seller_point" => $average_seller_point,
            "average_customer_point" => $average_customer_point,
            "follow_count" => $follow_count,
            "follower_count" => $follower_count,
        ];

        return view("user.info", $data);
    }
    //スタイリストとのチャットページに移動
    function chat_stylist($id){
        $chat_f = new ChatFunction();
        $message_list = $chat_f->stylist_customer_get_message($id);
        return view("user.chat_stylist",compact('message_list'));
    }

    // 出品商品一覧画面の表示
    public function exhibited_index(Request $request)
    {
        // セッションからuserインスタンスを受け取る
        $user = unserialize($request->session()->get("user"));

        // ユーザーが出品した商品の中から、現在出品中の物を検索
        $exhibited_items = Item::where("user_id", $user->id)
                    ->where("onsale", 1)
                    ->with(["item_info", "item_photo"])
                    ->get();

        $data = [
            // msgの初期値
            "msg" => "",
            "exhibited_items" =>$exhibited_items,
        ];

        // リダイレクト時のmsgの代入
        // emailとpasswordの組み合わせが違う時のエラーメッセージが入る
        if ($request->old("msg")) {
            $data["msg"] = $request->old("msg");
        }

        // 出品商品一覧画面の表示
        return view("user.exhibited", $data);
    }

    // 商品を削除する処理
    public function exhibited_delete(Request $request)
    {
        // セッションからuserインスタンスを受け取る
        $user = unserialize($request->session()->get("user"));

        // item_idの代入
        $item_id = $request->id;

        // 該当のitem_idのonsaleを0に変更
        Item::where("id", $item_id)
            ->first()
            ->fill(["onsale" => 0])
            ->save();

        // メッセージの代入
        $data = [
            "msg" => "削除しました",
        ];

        // 出品商品一覧画面へリダイレクト
        return redirect("user/exhibited/" . $user->id)->withInput($data);
    }

    //フリーマチャット画面にいく
    function chat_trade($item_id){
        $chat_f = new ChatFunction();
        $message_list = $chat_f->chat_trade($item_id);
        if($message_list!==false){
            return view('user.chat_trade',compact('message_list'));
        }else{
            //もしユーザがurlのitem_idに対応する商品の販売者か購入者じゃないと、チャットがない画面にいく
            return redirect(asset('not_found_chat'));
        }
    }

    // 購買履歴一覧画面の表示
    public function purchased_index(Request $request)
    {
        // セッションからuserインスタンスを受け取る
        $user = unserialize($request->session()->get("user"));

        // 購入済みの商品をDBから検索
        $purchased_items = Item_history::where("buyer_id", $user->id)->with("item_info")->get();

        $data = [
            "purchased_items" => $purchased_items,
        ];

        // 購買履歴一覧画面の表示
        return view("user.purchased", $data);
    }

    // 販売履歴一覧画面の表示
    public function sold_index(Request $request)
    {
        // セッションからuserインスタンスを受け取る
        $user = unserialize($request->session()->get("user"));

        // ユーザーが出品した商品の中から、販売済みの物を検索する
        // item_info, item_photo, item_historyと一緒に取り出す
        $sold_items = Item::where("user_id", $user->id)
            ->where("onsale", 2)
            ->with(["item_info", "item_photo", "item_history"])
            ->get();

        $data = [
            "sold_items" => $sold_items,
        ];

        // var_dump($sold_items->first());

        // 購買履歴一覧画面の表示
        return view("user.sold", $data);
    }

    // 注文履歴一覧画面の表示
    public function ordered_index(Request $request)
    {
        // セッションからuserインスタンスを受け取る
        $user = unserialize($request->session()->get("user"));


        $order_histories = Stylist_history::where("customer_id", $user->id)
            ->with("stylist_info")
            ->get();

        $data = [
            "order_histories" => $order_histories,
        ];

        // 購買履歴一覧画面の表示
        return view("user.ordered", $data);
    }

    // 注文履歴一覧画面の表示
    public function follower_index(Request $request)
    {
        // セッションからuserインスタンスを受け取る
        $user = unserialize($request->session()->get("user"));
        
        $followers_of_page_user = User_follower::where("follow_id", $request->id)
            ->with("user_info")
            ->get();

        $followers_of_access_user = User_follower::where("follow_id", $user->id)
            ->with("user_info")
            ->get();

        $data = [
            "user" => $user,
            "followers_of_page_user" => $followers_of_page_user,
            "followers_of_access_user" => $followers_of_access_user,
        ];

        // 購買履歴一覧画面の表示
        return view("user.follower", $data);
    }

    // フォローするボタンが押されたときの処理
    public function follow(Request $request)
    {
        // セッションからuserインスタンスを受け取る
        $user = unserialize($request->session()->get("user"));

        $follow_id = $request->follow_id;

        $user_follower = new User_follower;

        $values = [
            "follow_id" => $follow_id,
            "follower_id" => $user->id,
        ];

        $user_follower->fill($values)->save();

        $data = [
            "follow_id" => $follow_id,
        ];

        return $data;
    }

    public function unfollow(Request $request)
    {
        // セッションからuserインスタンスを受け取る
        $user = unserialize($request->session()->get("user"));

        $follow_id = $request->follow_id;

        $user_follower = User_follower::where("follow_id", $follow_id)
            ->where("followerid", $user->id)
            ->delete();

        $data = [
            "follow_id" => $follow_id,
        ];

        return $data;
    }

    // フォローするボタンが押されたときの処理
    // public function follow(Request $request)
    // {
    //     // セッションからuserインスタンスを受け取る
    //     $user = unserialize($request->session()->get("user"));
        
    //     $follow_id = $request->id;

    //     $user_follower = new User_follower;

    //     $values = [
    //         "follow_id" => $follow_id,
    //         "follower_id" => $user->id,
    //     ];
        
        
    //     // 購買履歴一覧画面の表示
    //     return view("user.follower", $data);
    // }


}
