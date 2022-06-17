<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreItemRequest;
use App\Models\Item;
use App\Models\Item_infos;
use App\Models\Item_photos;

class FleamarketController extends Controller
{
    // 4-1
    public function index(){
        // 全ユーザー閲覧可能
        // フリマの全商品を取得する
        

        // viewを返す
        return view('fleamarket.index');
    }


    // 4-9
    public function createIndex(){
        // ユーザー以外のアクセスをブロック
        // 出品登録画面へのviewを返す
        return view('fleamarket.create');
    }

    // 4-10
    public function createConfirm(StoreItemRequest $request){
        $item_infos = $request->validated();

        return view('fleamarket.create_confirm', ['item_infos' => $item_infos]);
    }

    // 4-11
    public function create(Request $request){
        // 戻るボタンが押された場合
        if ($request->get('back')) {
            return redirect('/fleamarket/exhibit/new')->withInput();
        }

        dump($request->all());
    }
}
