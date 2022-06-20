<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function userManageIndex(Request $request)
    {
        // セッションからmanagerインスタンスを受け取る
        // $manager = unserialize($request->session()->get("manager"));

        $users = User::with("User_info")->get();

        $data = [
            "users" => $users,
        ];

        return view("manager.user_manage", $data);
    }

    public function deleteUser(Request $request)
    {
        $user_id = $request->user_id;

        $user = User::where("id", $user_id)->first();
        $user->fill(["exist" => 0])->save();

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
        // $manager = unserialize($request->session()->get("manager"));

        $items = Item::where("onsale", "!=", "2")
            ->with(["Item_info", "Item_photo", "user_info"])
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
}
