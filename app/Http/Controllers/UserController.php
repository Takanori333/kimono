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
use App\Models\Customer_assessment;
use App\Models\Faq;
use App\Models\Item;
use App\Models\Item_history;
use App\Models\Seller_assessment;
use App\Models\Stylist_comment;
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
        // 入力値の代入
        $input_email = $request->email;
        $input_password = $request->password;

        // 入力されたemailに一致するものをusersから取り出す
        $user = User::where("email", $input_email)
            ->join("user_infos", "users.id", "=", "user_infos.id")
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

            } else {
                // emailとpasswordの組み合わせが正しくないときは、flgにfalseを代入
                $flg = false;
            }
        } else {
            $flg = false;
        }

        $data = [
            "msg" => "メールアドレスまたはパスワードが違います",
            "email" => $input_email,
        ];

        // emailとpasswordの組み合わせが正しくないとき
        // サインイン画面にリダイレクト
        if (!$flg) {
            return redirect(asset("user/signin"))->withInput($data);
        }
    }

    // サインアウトの処理
    public function signout(Request $request){
        $request->session()->forget('user');

        // フリマトップページにリダイレクト
        return redirect(asset("/fleamarket"));
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
        
        // 画像ファイルが選択されているとき
        if ($request->icon) {
            $icon_path = $request->file("icon")->store("image");
            $user_info_form["icon"] = $icon_path;
        }

        // DBに保存
        $user->fill($user_form)->save();
        $user_info->fill($user_info_form)->save();

        // 登録したユーザーのidを代入
        $user = User::join("user_infos", "users.id", "=", "user_infos.id")
            ->where("email", $request->email)
            ->where("exist", 1)
            ->first();

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

        // フォロー数とフォロワー数を計算
        $follower_count = User_follower::where("follow_id", $user->id)
            ->join("users", "user_followers.follower_id", "=", "users.id")
            ->where("users.exist", 1)
            ->count();
        $follow_count = User_follower::where("follower_id", $user->id)
            ->join("users", "user_followers.follow_id", "=", "users.id")
            ->where("users.exist", 1)
            ->count();

        $data = [
            "user" => $user,
            "follow_count" => $follow_count,
            "follower_count" => $follower_count,
        ];

        return view("user.info", $data);
    }

    //スタイリストとのチャットページに移動
    function chat_stylist($id){
        $user = unserialize(session()->get("user"));
        if($user){
            $chat_f = new ChatFunction();
            $message_list = $chat_f->stylist_customer_get_message($id);
            $stylist_info = $chat_f->stylist_customer_get_info($id);    
            return view("user.chat_stylist",["message_list"=>$message_list,"stylist_info"=>$stylist_info]);
        }
        return redirect(asset('/user/signin'));
    }

    // 出品商品一覧画面の表示
    public function exhibitedIndex(Request $request)
    {
        // セッションからuserインスタンスを受け取る
        $access_user = unserialize($request->session()->get("user"));

        // ページのユーザーidを受け取る
        $page_user_id = $request->id;

        // ログイン状態である確認
        // 未ログインのときはaccess_userがnullになる
        if ($access_user) {
            if ($access_user->id == $page_user_id) {
                $user_flg = true;
            } else {
                $user_flg = false;
            }
        } else {
            $user_flg = false;
        }

        // ユーザーが出品した商品の中から、現在出品中の物を検索
        $exhibited_items = Item::where("user_id", $request->id)
                    ->where("onsale", 1)
                    ->with(["item_info", "item_photo"])
                    ->get();

        $data = [
            // msgの初期値
            "msg" => "",
            "exhibited_items" =>$exhibited_items,
            "user_flg" => $user_flg,
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
        return redirect(asset("user/exhibited/". $user->id))->withInput($data);
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
                'item_id'=>$item_id,
                'item_name'=>$chat_info_list[4]
            ]);
        }else{
            //もしユーザがurlのitem_idに対応する商品の販売者か購入者じゃないと、チャットがない画面にいく
            return redirect(asset('notfound'));
        }
    }

    function chat(){
        $chat_f = new ChatFunction();
        $chat_list = $chat_f->user_chat_list();
        return view('user.chat',['trade_chat'=>$chat_list[0],'stylist_chat'=>$chat_list[1]]);
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
            "msg" => "",
            "order_histories" => $order_histories,
        ];

        // リダイレクト時のmsgの代入
        if ($request->old("msg")) {
            $data["msg"] = $request->old("msg");
        }

        // 注文履歴一覧画面の表示
        return view("user.ordered", $data);
    }

    public function order_detail($id){
        $user = unserialize(session()->get("user"));
        if($user){
            $reserve = DB::table('stylist_histories')->where("customer_id", $user->id)->where('stylist_histories.id','=',$id)->rightJoin('stylist_infos','stylist_histories.stylist_id','stylist_infos.id')->first();
            if($reserve){
                return view('user.order_detail',compact('reserve'));
            }
        }
        return redirect(asset('/unfound'));
    }

    public function assessStylist(Request $request)
    {
        // インスタンスを受け取る
        $order_history = json_decode($request->order_history);

        $stylist_comment = new Stylist_comment;

        // stylist_commentsに保存する値
        $values = [
            "stylist_id" => $order_history->stylist_id,
            "customer_id" => $order_history->customer_id,
            "stylist_history_id" => $order_history->id,
            "text" => $request->comment,
            "point" => $request->point,
        ];

        // DBに保存
        $stylist_comment->fill($values)->save();
        $avg_point = DB::table("stylist_comments")->where('stylist_id','=',$order_history->stylist_id)->avg('point');
        DB::table("stylist_infos")->where('stylist_id','=',$order_history->stylist_id)->update(['point'=>$avg_point]);
        // 注文一覧画面へリダイレクト
        return redirect(asset("/user/ordered/" . $order_history->customer_id))
            ->withInput(["msg" => "評価しました"]);
    }

    // フォロワー一覧画面の表示
    public function followerIndex(Request $request)
    {
        // セッションからuserインスタンスを受け取る
        $user = unserialize($request->session()->get("user"));
        
        // ページのユーザーのことをフォローしているユーザーを検索する
        // user,user_infosとjoinして取り出す
        // idカラムが重複するので、user_infosのidをuser_idとする
        $followers_of_page_user = User_follower::where("follow_id", $request->id)
            ->join("user_infos", "follower_id", "=", "user_infos.id")
            ->join("users", "follower_id", "=", "users.id")
            ->where("users.exist", "1")
            ->select("*", "user_infos.id as user_id")
            ->get();
 
        // ログイン状態化を判別
        // ログインしていないときは$userがnullになる
        if ($user) {
            // アクセスしたユーザーがフォローしている人を検索する
            // フォローしているユーザーのidを取り出し、配列に格納する
            // アクセスしたユーザーがフォローしているかで、フォローボタン等の表示を変える
            $follows_of_access_user = User_follower::where("follower_id", $user->id)
                ->join("users", "follower_id", "=", "users.id")
                ->where("users.exist", "1")
                ->select("follow_id")
                ->get()
                ->map(function ($row) {
                    return $row->follow_id;
                })
                ->toArray();
        } else {
            $follows_of_access_user = array();
        }

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
        // user, user_infosとjoinして取り出す
        // idカラムが重複するので、user_infosのidをuser_idとする
        $follows_of_page_user = User_follower::where("follower_id", $request->id)
            ->join("user_infos", "follow_id", "=", "user_infos.id")
            ->join("users", "follow_id", "=", "users.id")
            ->where("users.exist", "1")
            ->select("*", "user_infos.id as user_id")
            ->get();

        // ログイン状態化を判別
        // ログインしていないときは$userがnullになる
        if ($user) {        
            // アクセスしたユーザーがフォローしている人を検索する
            // フォローしているユーザーのidを取り出し、配列に格納する
            // アクセスしたユーザーがフォローしているかで、フォローボタン等の表示を変える
            $follows_of_access_user = User_follower::where("follower_id", $user->id)
                ->join("users", "follower_id", "=", "users.id")
                ->select("follow_id")
                ->where("users.exist", "1")
                ->get()
                ->map(function ($row) {
                    return $row->follow_id;
                })
                ->toArray();
        } else {
            $follows_of_access_user = array();
        }
        
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

        // 画像ファイルが選択されているとき
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

        // ユーザー情報変更画面へリダイレクト
        return redirect(asset("user/edit/". $user->id))->withInput($data); 
    }

    // ユーザープロフィール画面の表示
    public function showIndex(Request $request)
    {   
        $access_user = unserialize($request->session()->get("user"));

        // アクティブユーザーのみを検索
        // アクティブユーザーでないときは、プロフィール画面を表示させない
        $page_user = User::where("id", $request->id)
            // ->where("exist", 1)    
            ->first();

        // フォロー数とフォロワー数を計算
        $follower_count = User_follower::where("follow_id", $page_user->id)
            ->join("users", "follower_id", "=", "users.id")
            ->where("users.exist", "1")
            ->count();
        $follow_count = User_follower::where("follower_id", $page_user->id)
            ->join("users", "follow_id", "=", "users.id")
            ->where("users.exist", "1")    
            ->count();

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
            "follow_flg" => $follow_flg,
            "follow_count" => $follow_count,
            "follower_count" => $follower_count,
            "exhibited_items" =>$exhibited_items,
        ];

        // ユーザープロフィール画面の表示
        return view("user.show", $data);
    }

    // FAQ画面の表示
    public function faq()
    {
        // 論理削除されていないFAQを抽出
        $faqs = Faq::where("exist", 1)->get();

        $data = [
            "faqs" => $faqs,
        ];

        // FAQ画面の表示
        return view("user.faq", $data);
    }

    // 購入者評価一覧画面の表示
    public function getCustomerAssessment(Request $request)
    {
        // ページのユーザーのidを取得
        $id = $request->id;
        $page_user = User::where("id", $id)->first();

        // ページのユーザーが評価されている情報を取り出す
        // users,user_infosとjoinして取り出す
        $assessment_users = Customer_assessment::where("to_id", $id)
            ->join("user_infos", "customer_assessments.from_id", "=", "user_infos.id")
            ->join("users", "users.id", "=", "customer_assessments.from_id")
            ->select("*", "users.id as user_id", "customer_assessments.created_at as assessment_date")
            ->get();

        $data = [
            "page_user" => $page_user,
            "assessment_users" => $assessment_users,
        ];

        // 購入者評価一覧画面の表示
        return view("user.customer_assessment", $data);
    }

    // 販売者評価一覧画面の表示
    public function getSellerAssessment(Request $request)
    {
        // ページのユーザーのidを取得
        $id = $request->id;
        $page_user = User::where("id", $id)->first();

        // ページのユーザーが評価されている情報を取り出す
        // users,user_infosとjoinして取り出す
        $assessment_users = Seller_assessment::where("to_id", $id)
            ->join("user_infos", "seller_assessments.from_id", "=", "user_infos.id")
            ->join("users", "users.id", "=", "seller_assessments.from_id")
            ->select("*", "users.id as user_id", "seller_assessments.created_at as assessment_date")
            ->get();

        $data = [
            "page_user" => $page_user,
            "assessment_users" => $assessment_users,
        ];

        // 購入者評価一覧画面の表示
        return view("user.seller_assessment", $data);
    }

}
