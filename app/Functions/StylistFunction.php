<?php
    namespace App\Functions;

    use App\Classes\Stylist;
    use App\Models\Stylist as StylistDB;
    use App\Models\Stylist_info;
    use App\Models\Stylist_area;
    use App\Models\Stylist_service;
    use App\Models\Stylist_freetime;
use App\Models\Stylist_history;
use Illuminate\Http\Request;
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\DB;
    
    class StylistFunction{
        function __construct()
        {
            
        }
        //スタイリストトップページ（一覧）
        function top(Request &$request){
            $area = $request->area;
            $service = $request->service;
            $sort = $request->sort;
            // $sort = $request->sort;
            $sql = DB::table('stylist_infos')->selectRaw('stylist_infos.id as id,name,icon,max_price,min_price,areas.area,services.service,stylist_infos.point as point');
            $services = DB::table('stylist_services')->selectRaw('stylist_id,GROUP_CONCAT(service) as service')->groupBy('stylist_id');
            $areas = DB::table('stylist_areas')->selectRaw('stylist_id,GROUP_CONCAT(area) as area')->groupBy('stylist_id');
            $stylist_ids = [];
            if($area){
                $area_DB = DB::table('stylist_areas')->where('area','=',$area)->pluck('stylist_id');
                $stylist_id = [];
                foreach($area_DB as $id){
                    $stylist_id[] = $id;
                }
                $sql = $sql->whereIn('id',$stylist_id);
            }
            if($service){                
                $service_DB = DB::table('stylist_services')->where('service','=',$service)->pluck('stylist_id');
                $stylist_id = [];
                foreach($service_DB as $id){
                    $stylist_id[] = $id;
                }
                $sql = $sql->whereIn('id',$stylist_id);
            }
            if($sort=="point"){
                $sql = $sql->orderByDesc($sort);
            }else if($sort=="min_price"){
                $sql = $sql->orderBy($sort);
            }
            $stylist_list = $sql->joinSub($areas,"areas",function($join){
                $join->on('stylist_infos.id','=','areas.stylist_id');
            })->joinSub($services,"services",function($join){
                $join->on('stylist_infos.id','=','services.stylist_id');
            })->paginate(9)->withQueryString();//エラーのハイライトがあれば、無視していい
            return $stylist_list;
        }
        function stylist_info($id){
            $stylist = DB::table('stylist_infos')->where('id','=',$id)->first();
            $services = DB::table('stylist_services')->where('stylist_id','=',$id)->pluck("service");
            $service = [];
            foreach($services as $s){
                $service[] = $s;
            }            
            $areas = DB::table('stylist_areas')->where('stylist_id','=',$id)->pluck("area");
            $area = [];
            foreach($areas as $a){
                $area[] = $a;
            }
            return [$stylist,implode(" , ",$service),implode(" , ",$area)];
        }
        //予約画面
        function reserve($reserve_id){
            // $user = unserialize(session()->get("user"));
            // $user_id = $user->getId();
            $user_id = 9999999;
            $reserve = DB::table('stylist_reserves')->where('reserve_id','=',$reserve_id)->first();
            var_dump($reserve);
            if($reserve->customer_id==$user_id){
                return $reserve;
            }
            return false;
            // var_dump($reserve);
        }
        //予約を決定する
        function confirm(Request &$request){
            $reserve = DB::table('stylist_reserves')->where('reserve_id','=',$request->reserve_id)->first();
            $stylist_history = new Stylist_history();
            $stylist_history->stylist_id = $reserve->stylist_id;
            $stylist_history->customer_id = $reserve->customer_id;
            $stylist_history->price = $reserve->price;
            $stylist_history->services = $reserve->services;
            $stylist_history->start_time = $reserve->start_time;
            $stylist_history->end_time = $reserve->end_time;    
            $stylist_history->address = $request->address;
            $stylist_history->count = $request->count;
            $stylist_history->save();
            DB::table('stylist_reserves')->where('reserve_id','=',$request->reserve_id)->delete();
        }
    }