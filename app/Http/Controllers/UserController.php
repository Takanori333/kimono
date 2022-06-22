<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\User_info;
use App\Models\User_follower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Functions\ChatFunction;
use App\Http\Requests\SigninRequest;
use App\Http\Requests\SignupRequest;
use App\Http\Requests\UserEditRequest;
use App\Models\Faq;
use App\Models\Item;
use App\Models\Item_history;
use App\Models\Stylist_history;
use App\Models\Trade_status;
use Illuminate\Support\Facades\DB;
use Symfony\Component\VarDumper\VarDumper;

class UserController extends Controller
{
    // サインイン画面の表示
    public function signinIndex(Request $request)
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
    public function signin(SigninRequest $request)
    {
        // バリデーションチェック

        // 入力値の代入
        $input_email = $request->email;
        $input_password = $request->password;

        // 入力されたemailに一致するものをusersから取り出す
        $user = User::where("email", $input_email)
            ->where("exist", 1)
            ->first();

        // flgの初期値
        $flg = true;

        // 入力されたemailに一致するものがあったときの処理
        // なかったときは$userにNULLが入る
        if ($user) {
            if ($input_password == $user->password) {
                // セッションにuserのインスタンスを格納
                $request->session()->put("user", serialize($user));

                // フリマトップページにリダイレクト
                return redirect(asset("/fleamarket"));

                // 今は、フリマトップページができていないので、ユーザー情報画面にリダイレクト
                // return redirect(asset("user/info/$user->id"));
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
            return redirect(asset("user/signin"))->withInput(["msg" => "メールアドレスまたはパスワードが違います"]);
        }
    }

    // サインアウトの処理
    public function signout(Request $request){
        // $request->session()->get('user');
        $request->session()->forget('user');

        // リダイレクト
        // return redirect();
    }

    // サインアップの処理
    public function signup(SignupRequest $request)
    {
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
            "height" => $request->height,
            "phone" => $request->phone,
            "post" => $request->post,
            "birthday" => $request->year . "-" . $request->month . "-" . $request->day,
        ];
        
        if ($request->icon) {
            $icon_path = $request->file("icon")->store("image");
            $user_info_form["icon"] = $icon_path;
        }

        // DBに保存
        $user->fill($user_form)->save();
        $user_info->fill($user_info_form)->save();

        // 登録したユーザーのidを代入
        $user = User::where("email", $request->email)->first();

        // セッションにuserのインスタンスを格納
        $request->session()->put("user", serialize($user));

        // フリマトップページへリダイレクト
        return redirect(asset("/fleamarket"));

        // 今は、フリマトップページができていないので、ユーザー情報画面にリダイレクト
        // return redirect("user/info/$user->id");
    }

    // ユーザー情報ページの表示
    public function infoIndex(Request $request)
    {
        // セッションからuserインスタンスを受け取る
        $user = unserialize($request->session()->get("user"));

        //  平均評価を計算し、代入
        // $average_seller_point = $user->getAverageSellerPoint();
        // $average_customer_point = $user->getAverageCustomerPoint();

        // フォロー数とフォロワー数を計算
        $follower_count = User_follower::where("follow_id", $user->id)->count();
        $follow_count = User_follower::where("follower_id", $user->id)->count();

        $data = [
            "user" => $user,
            // "average_seller_point" => $average_seller_point,
            // "average_customer_point" => $average_customer_point,
            "follow_count" => $follow_count,
            "follower_count" => $follower_count,
        ];

        return view("user.info", $data);
    }

    //スタイリストとのチャットページに移動
    function chat_stylist($id){
        $chat_f = new ChatFunction();
        $message_list = $chat_f->stylist_customer_get_message($id);
        $stylist_info = $chat_f->stylist_customer_get_info($id);
        return view("user.chat_stylist",["message_list"=>$message_list,"stylist_info"=>$stylist_info]);
}

    // 出品商品一覧画面の表示
    public function exhibitedIndex(Request $request)
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
        return redirect(asset("user/exhibited/") . $user->id)->withInput($data);
    }

    //フリーマチャット画面にいく
    function chat_trade($item_id){
        $chat_f = new ChatFunction();
        $chat_info_list = $chat_f->chat_trade($item_id);
        if($chat_info_list!==false){
            return view('user.chat_trade',[
                'message_list'=>$chat_info_list[0],
                'buyer_info'=>$chat_info_list[1],
                'seller_info'=>$chat_info_list[2],
                'status'=>$chat_info_list[3],
                'item_id'=>$item_id
            ]);
        }else{
            //もしユーザがurlのitem_idに対応する商品の販売者か購入者じゃないと、チャットがない画面にいく
            return redirect(asset('not_found_chat'));
        }
    }

    // 購買履歴一覧画面の表示
    public function purchasedIndex(Request $request)
    {
        // セッションからuserインスタンスを受け取る
        $user = unserialize($request->session()->get("user"));

        // 購入済みの商品をDBから検索
        $purchased_items = Item_history::where("buyer_id", $user->id)
            ->with(["item_info", "trade_status"])
            ->get();

        $data = [
            "user" => $user,
            "purchased_items" => $purchased_items,
        ];

        // 購買履歴一覧画面の表示
        return view("user.purchased", $data);
    }

    // 販売履歴一覧画面の表示
    public function soldIndex(Request $request)
    {
        if ($request->session()->get("user")) {
            // セッションからuserインスタンスを受け取る
            $access_user = unserialize($request->session()->get("user"));
        } else {
            $access_user = null;
        }

        $page_user = User::where("id", $request->id)->first();

        // ユーザーが出品した商品の中から、販売済みの物を検索する
        // item_info, item_photo, item_historyと一緒に取り出す
        $sold_items = Item::where("user_id", $page_user->id)
            ->where("onsale", 2)
            ->with(["item_info", "item_photo", "item_history", ])
            ->get();

        $data = [
            "access_user" => $access_user,
            "sold_items" => $sold_items,
        ];

        // var_dump($sold_items->first()->item_history->buyer_id);

        // 購買履歴一覧画面の表示
        return view("user.sold", $data);
    }

    // 注文履歴一覧画面の表示
    public function orderedIndex(Request $request)
    {
        // セッションからuserインスタンスを受け取る
        $user = unserialize($request->session()->get("user"));

        // ユーザーのスタイリストへの注文履歴を検索する
        // stylist_infoと一緒に取り出す
        $order_histories = Stylist_history::where("customer_id", $user->id)
            ->with("stylist_info")
            ->get();

        $data = [
            "order_histories" => $order_histories,
        ];

        // 注文履歴一覧画面の表示
        return view("user.ordered", $data);
    }

    // フォロワー一覧画面の表示
    public function followerIndex(Request $request)
    {
        // セッションからuserインスタンスを受け取る
        $user = unserialize($request->session()->get("user"));
        
        // ページのユーザーのことをフォローしているユーザーを検索する
        // user_infosとjoinして取り出す
        // idカラムが重複するので、user_infosのidをuser_idとする
        $followers_of_page_user = User_follower::where("follow_id", $request->id)
            ->join("user_infos", "follower_id", "=", "user_infos.id")
            ->select("*", "user_infos.id as user_id")
            ->get();
 
        // アクセスしたユーザーがフォローしている人を検索する
        // フォローしているユーザーのidを取り出し、配列に格納する
        // アクセスしたユーザーがフォローしているかで、フォローボタン等の表示を変える
        $follows_of_access_user = User_follower::where("follower_id", $user->id)
            ->select("follow_id")
            ->get()
            ->map(function ($row) {
                return $row->follow_id;
            })
            ->toArray();

        $data = [
            "user" => $user,
            "followers_of_page_user" => $followers_of_page_user,
            "follows_of_access_user" => $follows_of_access_user,
        ];

        // フォロワー一覧画面の表示
        return view("user.follower", $data);
    }

    // フォローするボタンが押されたときの処理
    public function follow(Request $request)
    {
        // セッションからuserインスタンスを受け取る
        $user = unserialize($request->session()->get("user"));

        // フォローするユーザーのidを取得
        $follow_id = $request->follow_id;

        // フォロー情報があるか検索
        // ないときは新しいインスタンスを作る
        $user_follower = User_follower::firstOrNew([
            "follow_id" => $follow_id,
            "follower_id" => $user->id,
        ]);

        // DBに保存する値
        $values = [
            "follow_id" => $follow_id,
            "follower_id" => $user->id,
        ];

        // DBに保存
        $user_follower->fill($values)->save();

        // JSにフォローしたユーザーのidを返す
        $data = [
            "follow_id" => $follow_id,
        ];

        return $data;
    }

    // 解除するボタンが押された時の処理
    public function unfollow(Request $request)
    {
        // セッションからuserインスタンスを受け取る
        $user = unserialize($request->session()->get("user"));

        // 削除するユーザーのidを取得
        $follow_id = $request->follow_id;

        // DBからフォロー情報を削除
        User_follower::where("follow_id", $follow_id)
            ->where("follower_id", $user->id)
            ->delete();

        // JSに削除したユーザーのidを返す
        $data = [
            "follow_id" => $follow_id,
        ];

        return $data;
    }

    // フォロー一覧画面の表示
    public function followIndex(Request $request)
    {
        // セッションからuserインスタンスを受け取る
        $user = unserialize($request->session()->get("user"));

        // ページのユーザーがフォローしているユーザーを検索する
        // user_infosとjoinして取り出す
        // idカラムが重複するので、user_infosのidをuser_idとする
        $follows_of_page_user = User_follower::where("follower_id", $request->id)
            ->join("user_infos", "follow_id", "=", "user_infos.id")
            ->select("*", "user_infos.id as user_id")
            ->get();

        // アクセスしたユーザーがフォローしている人を検索する
        // フォローしているユーザーのidを取り出し、配列に格納する
        // アクセスしたユーザーがフォローしているかで、フォローボタン等の表示を変える
        $follows_of_access_user = User_follower::where("follower_id", $user->id)
            ->select("follow_id")
            ->get()
            ->map(function ($row) {
                return $row->follow_id;
            })
            ->toArray();

        $data = [
            "user" => $user,
            "follows_of_page_user" => $follows_of_page_user,
            "follows_of_access_user" => $follows_of_access_user,
        ];

        // フォロー一覧画面の表示
        return view("user.follow", $data);
    }

    // ユーザー情報変更画面の表示
    public function editIndex(Request $request)
    {
        // セッションからuserインスタンスを受け取る
        $user = unserialize($request->session()->get("user"));

        $data = [
            "user" => $user,
            // msgの初期値
            "msg" => ""
        ];

        // リダイレクト時のmsgの代入
        if ($request->old("msg")) {
            $data["msg"] = $request->old("msg");
        }

        // ユーザー情報変更画面の表示
        return view("user.edit", $data);
    }

    // ユーザー情報変更処理
    public function editUser(UserEditRequest $request)
    {
        // セッションからuserインスタンスを受け取る
        $user = unserialize($request->session()->get("user"));

        // バリデーションチェック
        $user_count = User::where("email", $request->email)
            ->where("id", "!=", $user->id)    
            ->count();

        if (!$user_count) {
            // $user = User::where("id", $request->id)->first();
            $user_info = User_info::where("id", $user->id)->first();
            
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

            if ($request->icon) {
                $icon_path = $request->file("icon")->store("image");
                $user_info_form["icon"] = $icon_path;
            }
    
            // DBに保存
            $user->fill($user_form)->save();
            $user_info->fill($user_info_form)->save();
    
            // セッションのuserインスタンスを更新
            $request->session()->put("user", serialize($user));
    
            $data = [
                // 変更完了メッセージ
                "msg" => "変更しました"
            ];
        } else {
            $data = [
                // エラーメッセージ
                "msg" => "そのメールアドレスは既に使用されています"
            ];
        }

        // ユーザー情報変更画面へリダイレクト
        return redirect(asset("user/edit/". $user->id))->withInput($data);   
    }

    // ユーザープロフィール画面の表示
    public function showIndex(Request $request)
    {
        
        $access_user = unserialize($request->session()->get("user"));
        $page_user = User::where("id", $request->id)->first();

        // //  平均評価を計算し、代入
        // $average_seller_point = $page_user->getAverageSellerPoint();
        // $average_customer_point = $page_user->getAverageCustomerPoint();

        // フォロー数とフォロワー数を計算
        $follower_count = User_follower::where("follow_id", $page_user->id)->count();
        $follow_count = User_follower::where("follower_id", $page_user->id)->count();

        // ユーザーが出品した商品の中から、現在出品中の物を検索
        $exhibited_items = Item::where("user_id", $page_user->id)
                    ->where("onsale", 1)
                    ->with(["item_info", "item_photo"])
                    ->get();

                    
        // ログイン状態であるかを判別
        if ($access_user) {
            // アクセスしたユーザーがページのユーザーをフォローしているかを検索
            // フォローしていないときはnullになる
            $user_follower = User_follower::where("follow_id", $page_user->id)
                ->where("follower_id", $access_user->id)
                ->first();
            
            if ($access_user->id == $page_user->id) {
                // アクセスしたユーザーとページのユーザーが一緒の時はフォローボタンを表示しない
                $follow_flg = "myself";
            } elseif ($user_follower) {
                // アクセスしたユーザーがページのユーザーをフォローしているときは解除ボタンの表示
                $follow_flg = "unfollow";
            } else {
                // アクセスしたユーザーがページのユーザーをフォローしていないときはフォローボタンの表示
                $follow_flg = "follow";
            }
        } else {
            // ログイン状態じゃないとき
            $follow_flg = "guest";
        }

        $data = [
            "page_user_id" => $request->id,
            "user" => $page_user,
            // "average_seller_point" => $average_seller_point,
            // "average_customer_point" => $average_customer_point,
            "follow_flg" => $follow_flg,
            "follow_count" => $follow_count,
            "follower_count" => $follower_count,
            "exhibited_items" =>$exhibited_items,
        ];

        // ユーザープロフィール画面の表示
        return view("user.show", $data);
    }

    public function faq()
    {
        $faqs = Faq::where("exist", 1)->get();

        $data = [
            "faqs" => $faqs,
        ];

        return view("user.faq", $data);
    }
}
