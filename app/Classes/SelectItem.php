<?php

namespace App\Classes;

use App\Models\Item;
use App\Models\Item_info;
use App\Models\Item_photo;
use App\Models\Item_comment;
use App\Models\User_info;

class SelectItem{
    public static function getAllItemInfos(){
        // フリマの全商品を取得する
        $temp_infos = Item::join('item_infos', 'items.id', '=' ,'item_infos.id')
        ->select('items.user_id', 'items.onsale', 'item_infos.*')
        ->get()
        ->toArray();
        // 画像ファイルを全て配列に格納する
        $item_infos = array();
        foreach( $temp_infos as $temp_info ){
            // 画像の追加
            $item_images = Item_photo::where('item_id', '=', $temp_info['id'])->get()->toArray();
            $temp_info['image'] = $item_images;
            
            // ユーザー情報の追加
            $user_info = User_info::where('id', '=', $temp_info['user_id'])->first()->toArray();
            $temp_info['user_info'] = $user_info;

            // datetime型の加工
            $temp_info['created_at'] = self::dateTimeMolding($temp_info['created_at']);
            $temp_info['updated_at'] = self::dateTimeMolding($temp_info['updated_at']);
            $temp_info['user_info']['created_at'] = self::dateTimeMolding($temp_info['user_info']['created_at']);
            $temp_info['user_info']['updated_at'] = self::dateTimeMolding($temp_info['user_info']['updated_at']);

            $item_infos[] = $temp_info;
        }

        return $item_infos;
    }

    public static function getSearchedItemInfos($keyword){
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
        $item_infos = self::getAllItemInfos();
        // 検索対象のカラムを設定
        $columns = [
            'name',
            'detail',
            'price',
            'category',
            'material',
            'item_status',
            'smell',
            'color',
            'area',
        ];

        $result_items = array();

        // 商品1つ1つにキーワードが含まれるか検索する
        foreach( $item_infos as $item_info ){

            $is_match_kw = true;
            $id = $item_info["id"];
            foreach( $keywords as $kw ){
                $is_match_column = false;

                // 検索用の文字列を作成する
                $pat = '%' . addcslashes($kw, '%_\\') . '%';
                foreach( $columns as $column ){
                    $result = Item_info::where('id', '=', $id)
                    ->where($column, 'LIKE', $pat)
                    ->get();
                    // dump("3  kw: " . $kw . ", column: " . $column . ", is_match:" . !$result->isEmpty());
                    // 部分一致するカラムが見つかったらブレイク
                    if( $is_match_column = !$result->isEmpty() ){
                        break;
                    }
                }

                // dump("2  is_not_match:" . !$is_match_column );
                if( !$is_match_column ){
                    // どのカラムにもキーワードが部分一致しないので$is_match_kwをfalseにしてbreak
                    $is_match_kw = $is_match_column;
                    break;
                }
            }

            // dump("1  " . $is_match_kw);
            if( $is_match_kw ){
                // 検索結果が存在するならば、商品を配列に追加
                $result_items[] = $item_info;
            }
        }

        return $result_items;
    }

    public static function getItemInfosById($id){
        // idから商品を検索する
        $temp_infos = Item::join('item_infos', 'items.id', '=' ,'item_infos.id')
        ->select('items.user_id', 'items.onsale', 'item_infos.*')
        ->where('item_infos.id', '=', $id)
        ->get()
        ->toArray();
        // 画像ファイルを全て配列に格納する
        $item_infos = array();
        foreach( $temp_infos as $temp_info ){
            // 画像の取得
            $item_images = Item_photo::where('item_id', '=', $temp_info['id'])->get()->toArray();
            $temp_info['image'] = $item_images;

            // ユーザー情報の追加
            $user_info = User_info::where('id', '=', $temp_info['user_id'])->first()->toArray();
            $temp_info['user_info'] = $user_info;

            // datetime型への加工
            $temp_info['created_at'] = self::dateTimeMolding($temp_info['created_at']);
            $temp_info['updated_at'] = self::dateTimeMolding($temp_info['updated_at']);
            $temp_info['user_info']['created_at'] = self::dateTimeMolding($temp_info['user_info']['created_at']);
            $temp_info['user_info']['updated_at'] = self::dateTimeMolding($temp_info['user_info']['updated_at']);


            $item_infos[] = $temp_info;
        }

        return $item_infos;
    }

    public static function getItemCommentsById($id){
        $item_info = self::getItemInfosById($id)[0];
        $seller_id = $item_info['user_id'];
        $item_comments = Item_comment::where('item_id', '=', $id)
        ->orderBy('created_at', 'asc')
        ->get()
        ->toArray();
        foreach( $item_comments as $key => $item_comment ){
            $user_info = User_info::where('id', '=', $item_comment['user_id'])
            ->select('name')
            ->first()
            ->toArray();
            $item_comments[$key]['user_name'] = $user_info['name'];
            $item_comments[$key]['is_seller'] = $seller_id == $item_comment['user_id'];
        }
        return $item_comments;
    }

    public static function dateTimeMolding($datetime){
        if( is_null($datetime) ){
            return [
                'year' => null,
                'month' => null,
                'day' => null,
                'hour' => null,
                'minutes' => null,
                'second' => null,
                'date' => '不明',
                'time' => '不明',
            ];
        }
        $temp = explode('T', $datetime);
        $date = $temp[0];
        $time = $temp[1];

        $temp = explode('-', $date);
        $year = $temp[0];
        $month = $temp[1];
        $day = $temp[2];

        $temp = explode(':', $time);
        $hour = $temp[0];
        $minutes = $temp[1];

        $temp = explode('.', $temp[2]);
        $second = $temp[0];

        $dateString = $year . '年' . $month . '月' . $day . '日';
        $timeString = $hour . '時' . $minutes . '分';

        return [
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'hour' => $hour,
            'minutes' => $minutes,
            'second' => $second,
            'date' => $dateString,
            'time' => $timeString
        ];
    }
}

