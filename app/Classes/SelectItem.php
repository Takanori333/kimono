<?php

namespace App\Classes;

use App\Models\Item;
use App\Models\Item_info;
use App\Models\Item_photo;
use App\Models\Item_comment;
use App\Models\User_info;
use Datetime;

class SelectItem{
    public static function getAllItemInfos(){
        // フリマの全商品を取得する
        $temp_infos = Item::join('item_infos', 'items.id', '=' ,'item_infos.id')
        ->select('items.user_id', 'items.onsale', 'item_infos.*')
        ->where('items.onsale', '!=', 0)
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
        ->where('items.onsale', '!=', 0)
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


    public static function getCategories($item_infos){
        $categories = array();
        foreach( $item_infos as $key => $item_info ){
            if( $key == 0 ){
                $categories[] = $item_info['category'];
            }else{
                $is_only = true;
                foreach( $categories as $category ){
                    if( $category == $item_info['category'] ){
                        $is_only = false;
                    }
                }
                if( $is_only ){
                    $categories[] = $item_info['category'];
                }
            }
        }
        return $categories;
    }

    // 絞り込み
    public static function filterItemInfos(&$item_infos, $is_only_sale=false, $selected_category=null){
        // 販売中のitem_infoを格納する配列
        $onsale_item_infos = array();
        // 選択されたカテゴリであるitem_infoを格納する配列
        $category_item_infos = array();
        // 上2つの配列に含まれるitem_infoを格納する配列
        $filtered_item_infos = array();

        if( gettype( $is_only_sale ) == 'string' ){
            if( $is_only_sale == 'true' ){
                $is_only_sale = true;
            }elseif( $is_only_sale == 'false' ){
                $is_only_sale = false;
            }
        }

        // 販売中のitem_infoを格納
        if( $is_only_sale ){
            foreach( $item_infos as $item_info ){
                if( $item_info['onsale'] == 1 ){
                    $onsale_item_infos[] = $item_info;
                }
            }
        }else{
            $onsale_item_infos = $item_infos;
        }

        // 選択されたカテゴリのitem_infoを格納
        if( !is_null( $selected_category ) ){
            foreach( $item_infos as $item_info ){
                if( $item_info['category'] == $selected_category ){
                    $category_item_infos[] = $item_info;
                }
            }
        }else{
            $category_item_infos = $item_infos;
        }

        // 両方に含まれるitem_infoを格納
        foreach( $onsale_item_infos as $onsale_item_info ){
            $is_both_exist = false;
            foreach( $category_item_infos as $category_item_info ){
                if( $onsale_item_info['id'] == $category_item_info['id'] ){
                    $is_both_exist = true;
                }
            }
            if( $is_both_exist ){
                $filtered_item_infos[] = $onsale_item_info;
            }
        }

        $item_infos = $filtered_item_infos;
    }


    // ソート
    public static function sortItemInfos(&$item_infos, $type=0){
        switch( $type ){
            case 0:
            case 1:
                self::sortItemDateTime($item_infos, $type);
                break;
            case 2:
            case 3:
                self::sortItemPrice($item_infos, $type);
                break;
            default:
                break;
        }
    }

    // 出品日時でのソート
    // $type [0->新しい順, 1->古い順]
    public static function sortItemDateTime(&$item_infos, $type){
        // 昇順(asc)->古い順, 降順(desc)->新しい順

        $created_ats = array();
        foreach( $item_infos as $item_info ){
            $year = is_null( $item_info['created_at']['year'] ) ? 1000:$item_info['created_at']['year'];
            $month = is_null( $item_info['created_at']['month'] ) ? 01:$item_info['created_at']['month'];
            $day = is_null( $item_info['created_at']['day'] ) ? 01:$item_info['created_at']['day'];
            $hour = is_null( $item_info['created_at']['hour'] ) ? 00:$item_info['created_at']['hour'];
            $minutes = is_null( $item_info['created_at']['minutes'] ) ? 00:$item_info['created_at']['minutes'];
            $second = is_null( $item_info['created_at']['second'] ) ? 00:$item_info['created_at']['second'];

            $str_datetime = $year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $minutes . ':' . $second;

            $objDateTime = new DateTime($str_datetime);
            $created_ats[] = $objDateTime;
        }

        // ソート後の$item_infos
        $sorted_item_infos = array();

        if( $type == 0 ){
            arsort($created_ats);
        }elseif( $type == 1 ){
            asort($created_ats);
        }
        foreach( $created_ats as $key => $created_at ){
            $sorted_item_infos[] = $item_infos[$key];
        }
        $item_infos = $sorted_item_infos;
    }

    // 値段でのソート
    // $type [2->値段が高い順, 3->値段が安い順]
    public static function sortItemPrice(&$item_infos, $type){
        // 昇順(asc)->安い順, 降順(desc)->高い順
        $prices = array();
        foreach( $item_infos as $item_info ){
            $prices[] = $item_info['price'];
        }

        // ソート後の$item_infos
        $sorted_item_infos = array();

        if( $type == 2 ){
            arsort($prices);
        }elseif( $type == 3 ){
            asort($prices);
        }
        foreach( $prices as $key => $price ){
            $sorted_item_infos[] = $item_infos[$key];
        }
        $item_infos = $sorted_item_infos;
    }
}

