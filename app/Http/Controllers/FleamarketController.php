<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Classes\ImageSave;
use App\Http\Requests\StoreItemRequest;
use App\Models\Item;
use App\Models\Item_info;
use App\Models\Item_photo;
use Illuminate\Support\Facades\DB;

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
    public function create(StoreItemRequest $request){
        // 戻るボタンが押された場合
        if ($request->get('back')) {
            return redirect('/fleamarket/exhibit/new')->withInput();
        }
        $item_infos = $request->validated();

        // トランザクション処理
        try {
            DB::beginTransaction();

            // itemsテーブルに値を追加
            $newRecord = Item::create([
                // 'user_id' => session()->get('user'),
                'user_id' => 1,
            ]);

            // item_infosに値を追加
            Item_info::create([
                'id'            => $newRecord->id,
                'name'          => $item_infos['name'],
                'detail'        => $item_infos['detail'],
                'price'         => $item_infos['price'],
                'category'      => $item_infos['category'],
                'material'      => $item_infos['material'],
                'item_status'   => $item_infos['status'],
                'smell'         => $item_infos['smell'],
                'color'         => $item_infos['color'],
                'height'        => $item_infos['size_heigh'],
                'length'        => $item_infos['size_length'],
                'sleeve'        => $item_infos['size_sleeve'],
                'sleeves'       => $item_infos['size_sleeves'],
                'front'         => $item_infos['size_front'],
                'back'          => $item_infos['size_back'],
            ]);

            // imageを一つずつ取り出してサーバーとデータベースに追加
            foreach( $item_infos['image'] as $key => $image ){
                $img_path = ImageSave::uploadBase64($image);
                // $img_path = $request->file('image')->store('public/image');
                Item_photo::create([
                    'item_id'   => $newRecord->id,
                    'path'      => $img_path,
                ]);
            }

            // 問題なくすべて追加出来れば処理内容を確定
            DB::commit();
        } catch (Throwable $e) {
            // 何らかの問題が発生した場合はすべての処理を戻す
            DB::rollBack();
        }

        return view('fleamarket.create_done');
    }
}
