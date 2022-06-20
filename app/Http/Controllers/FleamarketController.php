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
        $temp_infos = Item::join('item_infos', 'items.id', '=' ,'item_infos.id')
        ->select('items.user_id', 'item_infos.*')
        ->get()
        ->toArray();
        // 画像ファイルを全て配列に格納する
        $item_infos = array();
        foreach( $temp_infos as $temp_info ){
            $item_images = Item_photo::where('item_id', '=', $temp_info['id'])->get()->toArray();
            $temp_info['image'] = $item_images;
            $item_infos[] = $temp_info;
        }

        // viewを返す
        return view('fleamarket.index', compact('item_infos'));
    }

    // 4-2
    public function search(Request $request){
        $keyword = $request->all();

        // 検索ワードの前処理
        $keyword = $keyword['keyword'];
        //1.全角スペースを半角スペースに変換
        $keyword = str_replace('　', ' ', $keyword);
        //2.前後のスペース削除（trimの対象半角スペースのみなので半角スペースに変換後行う）
        $keyword = trim($keyword);
        //3.連続する半角スペースを半角スペースひとつに変換
        $keyword = preg_replace('/\s+/', ' ', $keyword);
        $keywords = explode(' ', $keyword);


        // AND検索
        // 全ての商品を取得する
        $item_infos = Item::join('item_infos', 'items.id', '=' ,'item_infos.id')
        ->select('items.user_id', 'item_infos.*')
        ->get()
        ->toArray();
        // 検索対象のカラムを設定
        $columns = [
            'name',
            'detail',
            'price',
            'category',
            'material',
            'item_status',
            'smell',
            'color'
        ];
        $result_items = array();
        // 商品1つ1つにキーワードが含まれるか検索する
        foreach( $item_infos as $item_info ){

            $is_match_kw = false;
            $id = $item_info["id"];
            foreach( $keywords as $kw ){
                $is_match_column = false;

                // 検索用の文字列を作成する
                $pat = '%' . addcslashes($kw, '%_\\') . '%';
                foreach( $columns as $column ){
                    $result = Item_info::where('id', '=', $id, 'and', $column, 'LIKE', $pat)->get();
                    dump("3  kw: " . $kw . ", column: " . $column . " is_match:" . !$result->isEmpty());
                    if( $is_match_column = !$result->isEmpty() ){
                        break;
                    }
                }

                dump("2  is_not_match:" . !$is_match_column );
                if( $is_match_kw = !$is_match_column ){
                    break;
                }
            }

            dump("1  " . $is_match_kw);
            if( $is_match_kw ){
                // 検索結果が存在するならば、商品を配列に追加
                $result_items[] = $item_info;
            }
        }

        dump($result_items);
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
