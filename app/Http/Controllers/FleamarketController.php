<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreItemCommentRequest;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\PurchaseItemRequest;
use  App\Classes\SelectItem;
use  App\Classes\ImageSave;
use App\Models\Item;
use App\Models\Item_info;
use App\Models\Item_photo;
use App\Models\Item_comment;
use App\Models\User_info;
use Illuminate\Support\Facades\DB;

class FleamarketController extends Controller
{
    // 4-1
    public function index(){
        $item_infos = SelectItem::getAllItemInfos();
        // viewを返す
        return view('fleamarket.index', compact('item_infos'));
    }

    // 4-2
    public function search(Request $request){
        $keyword = $request->all();
        $item_infos = SelectItem::getSearchedItemInfos($keyword);

        return view('fleamarket.search_result', compact('item_infos'));
    }

    // 4-4
    public function show($id){
        $item_info = SelectItem::getItemInfosById($id)[0];
        $item_comments = SelectItem::getItemCommentsById($id);

        return view('fleamarket.show', compact('item_info', 'item_comments'));
    }

    // 4-4-1(コメントアップロード用)
    public function uploadComment(StoreItemCommentRequest $request, $id){
        $reqData = $request->validated();

        // データベースにコメントを追加
        $comment = $reqData['comment'];
        $user_id = 1;
        // $user_id = session('user');
        Item_comment::create([
            'item_id' => $id,
            'user_id' => $user_id,
            'text' => $comment,
        ]);

        $item_comments = SelectItem::getItemCommentsById($id);

        return response()->json($item_comments);
    }

    // 4-5
    public function purchase($id){
        $item_info = SelectItem::getItemInfosById($id)[0];
        // $user_info = User_info::where('id', '=', session('user'))->first()->toArray();
        $user_info = User_info::where('id', '=', 1)->first()->toArray();
        $item_info['user_info'] = $user_info;

        return view('fleamarket.purchase', compact('item_info'));
    }

    // 4-6
    public function purchaseConfirm(PurchaseItemRequest $request, $id){
        $payment_way = $request->validated();
        $item_info = SelectItem::getItemInfosById($id)[0];

        dump($payment_way);
        dump($item_info);
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
                'area'          => $item_infos['pref'],
                'height'        => $item_infos['size_height'],
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

    // 4-12 商品編集画面
    public function edit($id){
        $item_infos = Item::join('item_infos', 'items.id', '=' ,'item_infos.id')
        ->where('items.id', '=', $id)
        ->select('items.user_id', 'item_infos.*')
        ->first();


        $temp_images = Item_photo::where('item_id', '=', $id)
        ->select('path')
        ->get();

        $item_images = array();
        foreach($temp_images as $temp_image){
            $item_images[] = $temp_image['path'];
        }


        return view('fleamarket.edit', compact('item_infos', 'item_images'));
    }

    // 4-13 商品編集確認画面
    public function editConfirm(StoreItemRequest $request, $id){
        // バリデーションチェック
        $item_infos = $request->validated();
        $item_infos['id'] = $request->get('id');

        return view('fleamarket.edit_confirm', ['item_infos' => $item_infos]);
    }

    // 編集確認画面からの画面遷移
    public function editDone(StoreItemRequest $request, $id){
        // 戻るボタンが押された場合
        if ($request->get('back')) {
            return redirect('/fleamarket/edit/'.$id)->withInput();
        }
        $item_infos = $request->validated();

        // トランザクション処理
        try {
            DB::beginTransaction();

            // itemsテーブルに値を追加
            Item::where('id', '=', $id)->update([
                // 'user_id' => session()->get('user'),
                'user_id' => 1,
            ]);

            // item_infosに値を追加
            Item_info::where('id', '=', $id)->update([
                'id'            => $id,
                'name'          => $item_infos['name'],
                'detail'        => $item_infos['detail'],
                'price'         => $item_infos['price'],
                'category'      => $item_infos['category'],
                'material'      => $item_infos['material'],
                'item_status'   => $item_infos['status'],
                'smell'         => $item_infos['smell'],
                'color'         => $item_infos['color'],
                'area'          => $item_infos['pref'],
                'height'        => $item_infos['size_height'],
                'length'        => $item_infos['size_length'],
                'sleeve'        => $item_infos['size_sleeve'],
                'sleeves'       => $item_infos['size_sleeves'],
                'front'         => $item_infos['size_front'],
                'back'          => $item_infos['size_back'],
            ]);

            // imageを一つずつ取り出してサーバーとデータベースに追加
            foreach( $item_infos['image'] as $key => $image ){
                if( explode('/',  $image)[0] != 'image' )
                {
                    $img_path = ImageSave::uploadBase64($image);
                    // $img_path = $request->file('image')->store('public/image');
                    Item_photo::create([
                        'item_id'   => $id,
                        'path'      => $img_path,
                    ]);
                }
            }

            // 問題なくすべて追加出来れば処理内容を確定
            DB::commit();
        } catch (Throwable $e) {
            // 何らかの問題が発生した場合はすべての処理を戻す
            DB::rollBack();
            $errors[] = "更新に失敗しました";
            $item_images = $item_infos['image'];
            return view('fleamarket.edit', compact('errors', 'item_infos', 'item_images'));
        }

        return redirect()->route('fleamarket')->with(['msg' => '更新しました。']);
    }
}
