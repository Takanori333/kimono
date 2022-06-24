<?php

namespace App\Http\Controllers;

use App\Http\Requests\FaqRequest;
use App\Http\Requests\SigninRequest;
use App\Models\Faq;
use App\Models\Item;
use App\Models\Stylist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    public function index()
    {
        return view("manager.index");
    }

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

        return view("manager.signin", $data);
    }

    // サインインの処理
    public function signin(SigninRequest $request)
    {
        // バリデーションチェック

        $manager_email = "manager@gmail.com";
        $manager_password = "password";
        
        // 入力値の代入
        $input_email = $request->email;
        $input_password = $request->password;

        if ($input_email == $manager_email and $input_password == $manager_password) {
            // セッションにmanagerのインスタンスを格納
            $request->session()->put("manager", "manager");

            // 管理者トップページにリダイレクト
            return redirect("/manager ");

            // 今は、管理者トップページができていないので、ユーザー管理画面にリダイレクト
            // return redirect("manager/user");
        } else {
            // emailとpasswordの組み合わせが正しくないとき
            // サインイン画面にリダイレクト
            return redirect("manager/signin")->withInput(["msg" => "メールアドレスまたはパスワードが違います"]);
        }
    }

    // サインアウトの処理
    public function signout(Request $request){
        $request->session()->forget('manager');

        // 管理者サインインページにリダイレクト
        return redirect(asset("/manager/signin"));
    }

    public function userManageIndex(Request $request)
    {
        // セッションからmanagerインスタンスを受け取る
        // $manager = $request->session()->get("manager");

        $users = User::with("User_info")
            // ->where("exist", "!=", "0")
            ->get();

        $data = [
            "users" => $users,
        ];

        return view("manager.user_manage", $data);
    }

    public function deleteUser(Request $request)
    {
        $user_id = $request->user_id;

        $user = User::where("id", $user_id)->first();
        $user->fill(["exist" => 2])->save();

        $data = [
            "user_id" => $user_id,
        ];

        return $data;
    }

    public function recoverUser(Request $request)
    {
        $user_id = $request->user_id;

        $user = User::where("id", $user_id)->first();
        $user->fill(["exist" => 1])->save();

        $data = [
            "user_id" => $user_id,
        ];

        return $data;
    }

    public function itemManageIndex(Request $request)
    {
        // セッションからmanagerインスタンスを受け取る
        // $manager = $request->session()->get("manager");

        $items = Item::where("onsale", "!=", "2")
            ->with(["item_info", "item_photo", "user_info"])
            ->get();

        $data = [
            "items" => $items,
        ];

        return view("manager.item_manage", $data);
    }

    public function deleteItem(Request $request)
    {
        $item_id = $request->item_id;

        $item = item::where("id", $item_id)->first();
        $item->fill(["onsale" => 0])->save();

        $data = [
            "item_id" => $item_id,
        ];

        return $data;
    }

    public function recoverItem(Request $request)
    {
        $item_id = $request->item_id;

        $item = item::where("id", $item_id)->first();
        $item->fill(["onsale" => 1])->save();

        $data = [
            "item_id" => $item_id,
        ];

        return $data;
    }

    public function stylistManageIndex(Request $request)
    {
        // セッションからmanagerインスタンスを受け取る
        // $manager = $request->session()->get("manager");

        $stylists = Stylist::where("exist", "!=", "0")
            ->with(["stylist_info", "stylist_area", "stylist_service","stylist_comment"])
            ->get();

        $data = [
            "stylists" => $stylists,
        ];

        return view("manager.stylist_manage", $data);
    }

    public function deleteStylist(Request $request)
    {
        $stylist_id = $request->stylist_id;

        $stylist = Stylist::where("id", $stylist_id)->first();
        $stylist->fill(["exist" => 2])->save();

        $data = [
            "stylist_id" => $stylist_id,
        ];

        return $data;
    }

    public function recoverStylist(Request $request)
    {
        $stylist_id = $request->stylist_id;

        $stylist = Stylist::where("id", $stylist_id)->first();
        $stylist->fill(["exist" => 1])->save();

        $data = [
            "stylist_id" => $stylist_id,
        ];

        return $data;
    }

    public function faqManageIndex(Request $request)
    {
        // セッションからmanagerインスタンスを受け取る
        // $manager = $request->session()->get("manager");

        $faqs = Faq::all();

        $data = [
            "faqs" => $faqs,
        ];

        return view("manager.faq_manage", $data);
    }

    public function deleteFaq(Request $request)
    {
        $faq_id = $request->faq_id;

        $faq = Faq::where("id", $faq_id)->first();
        $faq->fill(["exist" => 0])->save();

        $data = [
            "faq_id" => $faq_id,
        ];

        return $data;
    }

    public function recoverFaq(Request $request)
    {
        $faq_id = $request->faq_id;

        $faq = Faq::where("id", $faq_id)->first();
        $faq->fill(["exist" => 1])->save();

        $data = [
            "faq_id" => $faq_id,
        ];

        return $data;
    }

    public function editFaqIndex(Request $request)
    {
        $faq_id = $request->id;
        $msg = "";

        // リダイレクト時のmsgの代入
        if ($request->old("msg")) {
            $msg = $request->old("msg");
            $faq_id = $request->old("faq_id");
        }

        $faq = Faq::where("id", $faq_id)->first();

        $data = [
            "msg" => $msg,
            "faq" => $faq,
        ];

        return view("manager.faq_edit", $data);
    }

    public function editFaq(FaqRequest $request)
    {
        $faq_id = $request->faq_id;

        $faq = Faq::where("id", $faq_id)->first();

        $values = [
            "question" => $request->question,
            "answer" => $request->answer,
        ];
        
        $faq->fill($values)->save();
        
        $data = [
            "msg" => "変更しました",
            "faq_id" => $faq_id,
        ];

        return redirect("/manager/faq/edit/" . $faq_id)->withInput($data);
    }

    public function createFaqIndex(Request $request)
    {
        $data = [
            "msg" => "",
        ];

        // リダイレクト時のmsgの代入
        if ($request->old("msg")) {
            $data["msg"] = $request->old("msg");
        }

        return view("manager.faq_create", $data);
    }

    public function createFaq(FaqRequest $request)
    {
        $faq = new Faq;

        $values = [
            "question" => $request->question,
            "answer" => $request->answer,
        ];

        $faq->fill($values)->save();
        
        $data = [
            "msg" => "追加しました",
        ];

        return redirect("/manager/faq/create/")->withInput($data);
    }

    public function stylist_history($id){
        $reserve_list = DB::table('stylist_histories')->where("stylist_id","=",$id)->orderBy('start_time','desc')->orderBy('end_time','desc')->get();

        return view('manager.stylist_history',compact('reserve_list'));
    }

}
