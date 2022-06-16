<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\User_info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

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
                // セッションにuserのidを格納
                // $request->session()->put("user", $user->id);

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
        $id = User::where("email", $request->email)->first()->id;

        // セッションにuserのidを格納
        // $request->session()->put("user", $id);

        // フリマトップページへリダイレクト
        // return redirect("/fleamarket ");

        // 今はフリマトップページがないので、サインアップ画面を表示
        return view("user/signup");
    }

    // ユーザー情報ページの表示
    public function info_index(Request $request)
    {

        $id = $request->id;
        // 該当のidのユーザー情報をDBから取り出す
        $user = User::with("user_info")->where("id", $id)->first();

        // 販売者の合計評価点の初期値
        $all_seller_point = 0;
        $count = 0;

        // 販売者の評価点を取り出し、all_seller_pointに加算
        foreach ($user->seller_assessment as $seller_assessment)
        {
            $all_seller_point += $seller_assessment->point;
            $count++;
        }

        // 評価がされていないとき、countが0なのでエラーがでる
        if ($count) {
            // 販売者の平均評価の計算
            $average_seller_point = round($all_seller_point / $count, 1);
        } else {
            $average_seller_point = 0;
        }
        
        // 購入者の合計評価点の初期値
        $all_customer_point = 0;
        $count = 0;

        // 購入者の評価点を取り出し、all_customer_pointに加算
        foreach ($user->customer_assessment as $customer_assessment)
        {
            $all_customer_point += $customer_assessment->point;
            $count++;
        }

        // 評価がされていないとき、countが0なのでエラーがでる
        if ($count) {
            // 販売者の平均評価の計算
            $average_customer_point = round($all_customer_point / $count, 1);
        } else {
            $average_customer_point = 0;
        }

        $data = [
            "user" => $user,
            "average_seller_point" => $average_seller_point,
            "average_customer_point" => $average_customer_point,
        ];

        return view("user.info", $data);
    }
    //スタイリストとのチャットページに移動
    function chat_stylist($id){
        return view("user.chat_stylist");
    }
}
