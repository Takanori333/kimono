<?php
    namespace App\Functions;

    use App\Classes\Stylist;
    use App\Models\Stylist as StylistDB;
    use App\Models\Stylist_info;
    use App\Models\Stylist_area;
    use App\Models\Stylist_service;
    use App\Models\Stylist_freetime;
    use Illuminate\Http\Request;
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\DB;
    
    class StylistFunction{
        function __construct()
        {
            
        }

        function top(Request &$request){
            $area = $request->area;
            $service = $request->service;
            // $sort = $request->sort;
            $sql = DB::table('stylist_infos');
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
            $stylist_list = $sql->get();
            return $stylist_list;
        }
    }