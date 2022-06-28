<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Requests\StoreItemCommentRequest;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\PurchaseItemRequest;
use App\Http\Requests\ChangeItemFavoriteRequest;
use App\Classes\SelectItem;
use App\Classes\ImageSave;
use App\Models\Item;
use App\Models\Item_info;
use App\Models\Item_photo;
use App\Models\Item_comment;
use App\Models\Item_history;
use App\Models\Item_favorite;
use App\Models\User_info;
use App\Models\Trade_status;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class FleamarketController extends Controller
{
    const QUANTITY_PER_PAGE = 16;

    // 4-1 
    public function index(Request $request){
        $item_infos = SelectItem::getAllItemInfos();
        $categories = SelectItem::getCategories($item_infos);
        $sort_type = is_null( $request->get('sort') )? 0: $request->get('sort');
        $onsale = is_null( $request->get('onsale') )? false: $request->get('onsale');
        $selected_category = is_null( $request->get('category') )? null: $request->get('category');
        SelectItem::sortItemInfos($item_infos, $sort_type);
        SelectItem::filterItemInfos($item_infos, $onsale, $selected_category);
        $msg = null;
        if( count($item_infos) <= 0 ){
            $msg = "条件に一致する商品はありません";
        }

        // ページネーションのために前処理
        $page = is_null($request->get('page'))? 1 : $request->get('page');
        $item_infos_collection = collect( $item_infos );
        $parameter = explode(url()->current(), url()->full())[1];
        do{
            $item_infos = new LengthAwarePaginator(
                $item_infos_collection->forPage($page, self::QUANTITY_PER_PAGE), // 現在のページのsliceした情報(現在のページ, 1ページあたりの件数)
                count($item_infos_collection), // 総件数
                self::QUANTITY_PER_PAGE,
                $page, // 現在のページ(ページャーの色がActiveになる)
                ["path" => '/fleamarket' . $parameter ],
            );
            $page--;
            if( $page == 0 ){
                break;
            }
        }while( $item_infos->count() == 0 );

        return view('fleamarket.index', compact('item_infos', 'categories', 'msg', 'sort_type', 'onsale', 'selected_category'));
    }

    // 4-2
    public function search(Request $request){
        $keyword = $request->get('keyword');
        $item_infos = SelectItem::getSearchedItemInfos($keyword);
        $categories = SelectItem::getCategories($item_infos);
        $sort_type = is_null( $request->get('sort') )? 0: $request->get('sort');
        $onsale = is_null( $request->get('onsale') )? false: $request->get('onsale');
        $selected_category = is_null( $request->get('category') )? null: $request->get('category');
        SelectItem::sortItemInfos($item_infos, $sort_type);
        SelectItem::filterItemInfos($item_infos, $onsale, $selected_category);
        $msg = null;
        if( count($item_infos) <= 0 ){
            $msg = "条件に一致する商品はありません";
        }

        // ページネーションのために前処理
        $page = is_null($request->get('page'))? 1 : $request->get('page');
        $item_infos_collection = collect( $item_infos );
        $parameter = explode(url()->current(), url()->full())[1];
        do{
            $item_infos = new LengthAwarePaginator(
                $item_infos_collection->forPage($page, self::QUANTITY_PER_PAGE), // 現在のページのsliceした情報(現在のページ, 1ページあたりの件数)
                count($item_infos_collection), // 総件数
                self::QUANTITY_PER_PAGE,
                $page, // 現在のページ(ページャーの色がActiveになる)
                ["path" => '/fleamarket/search' . $parameter ],
            );
            $page--;
            if( $page == 0 ){
                break;
            }
        }while( $item_infos->count() == 0 );

        return view('fleamarket.search_result', compact('item_infos', 'categories', 'msg', 'sort_type', 'onsale', 'selected_category', 'keyword'));
    }

    // 4-3
    public function showFavorites(Request $request){
        if( is_null( session('user') ) ){
            return redirect('/fleamarket');
        }
        $user_id = unserialize(session('user'))->id;
        $item_ids = Item_favorite::where('user_id', '=', unserialize(session('user'))->id )
        ->select('item_id')
        ->get()
        ->toArray();

        $item_infos = array();
        $msg = null;
        if( ! is_null( $item_ids ) ){
            // お気に入りに追加している商品がある場合
            foreach( $item_ids as $item_id  ){
                if( count( SelectItem::getItemInfosById($item_id) ) > 0 ){
                    $item_infos[] = SelectItem::getItemInfosById($item_id)[0];
                }
            }
        }

        if( count( $item_infos ) <= 0 ){
            $msg = "お気に入りに追加された商品はありません";
        }

        $categories = SelectItem::getCategories($item_infos);
        $sort_type = is_null( $request->get('sort') )? 0: $request->get('sort');
        $onsale = is_null( $request->get('onsale') )? false: $request->get('onsale');
        $selected_category = is_null( $request->get('category') )? null: $request->get('category');
        $exist_category = false;
        foreach( $categories as $category ){
            if( $category == $selected_category ){
                $exist_category = true;
            }
        }
        if( !$exist_category ){
            $selected_category = null;
        }
        SelectItem::sortItemInfos($item_infos, $sort_type);
        SelectItem::filterItemInfos($item_infos, $onsale, $selected_category);
        if( count($item_infos) <= 0 && is_null( $msg ) ){
            $msg = "条件に一致する商品はありません";
        }


        // ページネーションのために前処理
        $page = is_null($request->get('page'))? 1 : $request->get('page');
        $item_infos_collection = collect( $item_infos );
        $parameter = explode(url()->current(), url()->full())[1];
        do{
            $item_infos = new LengthAwarePaginator(
                $item_infos_collection->forPage($page, self::QUANTITY_PER_PAGE), // 現在のページのsliceした情報(現在のページ, 1ページあたりの件数)
                count($item_infos_collection), // 総件数
                self::QUANTITY_PER_PAGE,
                $page, // 現在のページ(ページャーの色がActiveになる)
                ["path" => '/fleamarket/favorite' . $parameter ],
            );
            $page--;
            if( $page == 0 ){
                break;
            }
        }while( $item_infos->count() == 0 );

        return view('fleamarket.show_favorites', compact('item_infos', 'categories', 'msg', 'sort_type', 'onsale', 'selected_category'));
    }


    // 4-4
    public function show($id){
        $user = unserialize(session('user'));
        $item_info = SelectItem::getItemInfosById($id)[0];
        $item_comments = SelectItem::getItemCommentsById($id);
        if($user){
            $item_favorite_record = Item_favorite::where('item_id', '=', $id)
            ->where('user_id', '=', $user->id )
            ->first();
            $is_favorite = true;
            if( is_null($item_favorite_record) ){
                $is_favorite = false;
            }    
            return view('fleamarket.show', compact('item_info', 'item_comments', 'is_favorite'));
        }
        return view('fleamarket.show', compact('item_info', 'item_comments'));
    }

    // 4-4-1(コメントアップロード用)
    public function uploadComment(StoreItemCommentRequest $request, $id){
        $reqData = $request->validated();

        $user_id = unserialize(session('user'))->id;
        if( $reqData['user_id'] == $user_id ){
            // データベースにコメントを追加
            $comment = $reqData['comment'];
            Item_comment::create([
                'item_id' => $id,
                'user_id' => $user_id,
                'text' => $comment,
            ]);
            $item_comments = SelectItem::getItemCommentsById($id);
        }else{
            $item_comments = [
                'error' => '不正な値です',
            ];
        }

        return response()->json($item_comments);
    }

    // 4-4-2(お気に入り追加)
    public function insertFavorite(ChangeItemFavoriteRequest $request){
        $reqData = $request->validated();

        $item_id = $reqData['item_id'];
        $user_id = unserialize(session('user'))->id;

        if( $reqData['user_id'] == $user_id ){
            $item_favorite_records = Item_favorite::where('item_id', '=', $item_id)->where('user_id', '=', $user_id)->get();
            if( $item_favorite_records->isEmpty() ){
                // アイテムをお気に入りに登録していない場合
                Item_favorite::create([
                    'item_id' => $item_id,
                    'user_id' => $user_id
                ]);
                $msg = 'お気に入りに登録しました';
            }else{
                // 既にお気に入りに登録している場合
                $msg = '既にお気に入りに登録されています';
            }
        }else{
            $msg = '値が不正です';
        }

        return response()->json($msg);
    }

    // 4-4-3(お気に入り削除)
    public function deleteFavorite(ChangeItemFavoriteRequest $request){
        $reqData = $request->validated();

        $item_id = $request->get('item_id');
        $user_id = unserialize(session('user'))->id;

        if( $reqData['user_id'] == $user_id ){
            $item_favorite_records = Item_favorite::where('item_id', '=', $item_id)->where('user_id', '=', $user_id)->get();
            if( $item_favorite_records->isEmpty() ){
                // アイテムをお気に入りに登録していない場合
                $msg = 'お気に入りに登録されていません';
            }else{
                // 既にお気に入りに登録している場合
                Item_favorite::where('item_id', '=', $item_id)
                ->where('user_id', '=', $user_id)
                ->delete();
                $msg = 'お気に入りから削除しました';
            }
        }else{
            $msg = '値が不正です';
        }

        return response()->json($msg);
    }

    // 4-5
    public function purchase($id){
        if( is_null( session('user') ) ){
            return redirect('/user/signin');
        }
        $item_info = SelectItem::getItemInfosById($id)[0];
        $user_id = unserialize(session('user'))->id;
        if( $item_info['user_id'] == $user_id ){
            return redirect('/fleamarket');
        }
        $user_info = User_info::where('id', '=', $user_id)->first()->toArray();
        $item_info['user_info'] = $user_info;



        return view('fleamarket.purchase', compact('item_info'));
    }

    // 4-6
    public function purchaseConfirm(PurchaseItemRequest $request, $id){
        if( is_null( session('user') ) ){
            return redirect('/fleamarket');
        }
        $payment_way = $request->validated();
        $item_info = SelectItem::getItemInfosById($id)[0];
        $user_id = unserialize(session('user'))->id;
        if( $item_info['user_id'] == $user_id ){
            return redirect('/fleamarket');
        }

        return view('fleamarket.purchase_confirm', compact('item_info', 'payment_way'));
    }

    // 4-7
    public function purchaseDone(PurchaseItemRequest $request, $id){
        if( is_null( session('user') ) ){
            return redirect('/fleamarket');
        }
        $payment_way = $request->validated();
        // 戻るボタンが押された場合
        if ($request->get('back')) {
            return redirect('/fleamarket/purchase/' . $id)->withInput();
        }

        $item_info = SelectItem::getItemInfosById($id)[0];
        $user_id = unserialize(session('user'))->id;
        if( $item_info['user_id'] == $user_id ){
            return redirect('/fleamarket');
        }

        // トランザクション処理
        try {
            DB::beginTransaction();

            Trade_status::create([
                'item_id' => $id,
                'status' => 0,
            ]);

            Item_history::create([
                'item_id' => $id,
                'buyer_id' => $user_id,
            ]);

            Item::where('id', '=', $id)->update([
                'onsale' => 2,
            ]);

            // 問題なくすべて追加出来れば処理内容を確定
            DB::commit();
        } catch (Throwable $e) {
            // 何らかの問題が発生した場合はすべての処理を戻す
            DB::rollBack();
        }

        return view('fleamarket.purchase_done', compact('id'));
    }

    // 4-9
    public function createIndex(){
        if( is_null( session('user') ) ){
            return redirect('/user/signin');
        }
        // 出品登録画面へのviewを返す
        return view('fleamarket.create');
    }

    // 4-10
    public function createConfirm(StoreItemRequest $request){
        if( is_null( session('user') ) ){
            return redirect('/fleamarket');
        }
        $item_infos = $request->validated();
        return view('fleamarket.create_confirm', compact('item_infos'));
    }

    // 4-11
    public function create(StoreItemRequest $request){
        if( is_null( session('user') ) ){
            return redirect('/fleamarket');
        }
        // 戻るボタンが押された場合
        if ($request->get('back')) {
            return redirect('/fleamarket/exhibit/new')->withInput();
        }

        $item_info = $request->validated();
        $user_id = unserialize(session('user'))->id;

        // トランザクション処理
        try {
            DB::beginTransaction();

            // itemsテーブルに値を追加
            $newRecord = Item::create([
                'user_id' => $user_id,
            ]);

            // item_infosに値を追加
            Item_info::create([
                'id'            => $newRecord->id,
                'name'          => $item_info['name'],
                'detail'        => $item_info['detail'],
                'price'         => $item_info['price'],
                'category'      => $item_info['category'],
                'material'      => $item_info['material'],
                'item_status'   => $item_info['status'],
                'smell'         => $item_info['smell'],
                'color'         => $item_info['color'],
                'area'          => $item_info['pref'],
                'height'        => $item_info['size_height'],
                'length'        => $item_info['size_length'],
                'sleeve'        => $item_info['size_sleeve'],
                'sleeves'       => $item_info['size_sleeves'],
                'front'         => $item_info['size_front'],
                'back'          => $item_info['size_back'],
            ]);

            // imageを一つずつ取り出してサーバーとデータベースに追加
            foreach( $item_info['image'] as $key => $image ){
                $img_path = ImageSave::uploadBase64($image);
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
        if( is_null( session('user') ) ){
            return redirect('/fleamarket');
        }
        $item_info = Item::join('item_infos', 'items.id', '=' ,'item_infos.id')
        ->where('items.id', '=', $id)
        ->select('items.user_id', 'items.onsale', 'item_infos.*')
        ->first();

        $user_id = unserialize(session('user'))->id;
        if( $item_info['user_id'] != $user_id ){
            return redirect('/fleamarket');
        }


        $temp_images = Item_photo::where('item_id', '=', $id)
        ->select('path')
        ->get();

        $item_images = array();
        foreach($temp_images as $temp_image){
            $item_images[] = $temp_image['path'];
        }


        return view('fleamarket.edit', compact('item_info', 'item_images'));
    }

    // 4-13 商品編集確認画面
    public function editConfirm(StoreItemRequest $request, $id){
        if( is_null( session('user') ) ){
            return redirect('/fleamarket');
        }
        // バリデーションチェック
        $item_infos = $request->validated();
        $item_infos['id'] = $request->get('id');

        return view('fleamarket.edit_confirm', compact('item_infos'));
    }

    // 編集確認画面からの画面遷移
    public function editDone(StoreItemRequest $request, $id){
        if( is_null( session('user') ) ){
            return redirect('/fleamarket');
        }
        // 戻るボタンが押された場合
        if ($request->get('back')) {
            return redirect('/fleamarket/edit/'.$id)->withInput();
        }
        $item_infos = $request->validated();

        $image_paths = array();
        // トランザクション処理
        try {
            DB::beginTransaction();

            // itemsテーブルに値を追加
            Item::where('id', '=', $id)->update([
                'user_id' => unserialize(session('user'))->id,
                // 'user_id' => 1,
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

            // 現在の画像をすべて削除
            $image_paths = Item_photo::where('item_id', '=', $id)->select('path')->get()->toArray();
            Item_photo::where('item_id', '=', $id)
            ->delete();

            // imageを一つずつ取り出してサーバーとデータベースに追加
            foreach( $item_infos['image'] as $key => $image ){
                if( explode('/', $image)[0] != 'image' )
                {
                    $img_path = ImageSave::uploadBase64($image);
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

        foreach( $image_paths as $image_path ){
            Storage::disk('local')->delete($image_path);
        }

        return redirect()->route('fleamarket')->with(['msg' => '更新しました。']);
    }
}
