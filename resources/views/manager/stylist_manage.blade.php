<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>晴 re 着 - スタイリスト一覧</title>
    <link rel="icon" type="image/x-icon" href="{{asset('/image/tagicon.png')}}">    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('/css/star.css') }}">

</head>
<body>
    @include('header')
    <div class="container">
        <div class="contents pt-5 mt-5 w-100 mx-auto text-center">
            <h1>スタイリスト管理</h1>
            <div class="">
                <div class="text-center my-4 py-5">
                    @foreach ($stylists as $stylist)
                    <div class="w-75 row m-0 mx-auto border_shadow my-4">
                        <img src="{{ asset($stylist->stylist_info->icon) }}" width="263px" height="263px" alt="" class="col w-25 p-0">
                        <div class="col-sm">
                            <div class="mx-2 mt-4 text-start">
                                <a href="{{ asset('/stylist/show/' . $stylist->id)}}" class="link-dark text-decoration-none h5" target="_blank">{{ $stylist->stylist_info->name }}</a>
                            </div>
                            <p class="m-2 text-start">@if ($stylist->stylist_info->sex)男@else 女@endif {{ str_replace('-', '/', $stylist->stylist_info->birthday) }}</p>
                            <p class="m-2 text-start">{{ $stylist->email }}</p>
                            <p class="m-2 text-start">{{ $stylist->stylist_info->phone }}</p>
                            <div class="col text-start m-2">
                                評価:
                                @if ($stylist->stylist_comment->avg("point"))
                                    <div class="col Stars card-text mb-1 fs-2" style='--rating: {{$stylist->stylist_comment->avg("point")}};' aria-label='Rating of this product is {{$stylist->stylist_comment->avg("point")}} out of 5.'></div>
                                @else
                                    -
                                @endif
                            </div>
                            {{-- <p class="m-2 text-start">評価　５</p> --}}
                            <p class="m-2 text-start">{{ $stylist->stylist_info->post }}</p>
                            <p class="m-2 text-start text-break">{{ $stylist->stylist_info->address }}</p>
                        </div>
                        <div class="col my-3 ">
                            <p class="m-3 text-start text-break">料金　10000~20000</p>
                            <p class="m-3 text-start text-break">サービス内容:
                                @foreach ($stylist->stylist_service as $stylist_service)
                                    <span>{{ $stylist_service->service }}</span>
                                @endforeach</p>
                            <p class="m-3 text-start text-break">対応地域:
                                @foreach ($stylist->stylist_area as $stylist_area)
                                    <span>{{ $stylist_area->area }}</span>
                                @endforeach</p>
                            <a href="{{ asset('/manager/stylist/history/'.$stylist->id) }}" class="link-dark  text-start" target="_blank">活動履歴</a>
                            <div class="row d-flex justify-content-center">
                                @if ($stylist->exist == 1)
                                <button class="btn btn-outline-danger px-3 mt-4 mx-1 col-5 manage" id="delete{{ $stylist->id }}" value="{{ $stylist->id }}" name="delete">削除</button>
                                <button class="btn btn-outline-secondary px-3 mt-4 mx-1 col-5 manage" id="recover{{ $stylist->id }}" value="{{ $stylist->id }}"  name="recover" disabled>復旧</button>
                                @elseif ($stylist->exist == 2)
                                <button class="btn btn-outline-danger px-3 mt-4 mx-1 col-5 manage" id="delete{{ $stylist->id }}" value="{{ $stylist->id }}" name="delete"  disabled>削除</button>
                                <button class="btn btn-outline-secondary px-3 mt-4 mx-1 col-5 manage" id="recover{{ $stylist->id }}" value="{{ $stylist->id }}"  name="recover">復旧</button>
                                @endif
                            </div>
                        </div>
                    </div>            
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @include('footer')


    <script>
        $(function(){
            $(".manage").click(function(){
                let name = $(this).attr("name");
                let stylist_id = $(this).val();
                if (name == "delete") {
                    let delete_flg = window.confirm('本当に削除しますか？');
                    if (delete_flg) {
                        $.ajax({
                            type: "get",
                            url: "/manager/stylist/delete",
                            data: {"stylist_id": stylist_id},
                            dataType: "json"
                        }).done(function(data){
                            $("#delete" + data.stylist_id).prop("disabled", true);
                            $("#recover" + data.stylist_id).prop("disabled", false);
                        }).fail(function(XMLHttpRequest, textStatus, error){
                            console.log(error);
                        })
                    }
                } else if (name == "recover") {
                    let recover_flg = window.confirm('本当に復旧しますか？');
                    if (recover_flg) {
                        $.ajax({
                            type: "get",
                            url: "/manager/stylist/recover",
                            data: {"stylist_id": stylist_id},
                            dataType: "json"
                        }).done(function(data){
                            $("#delete" + data.stylist_id).prop("disabled", false);
                            $("#recover" + data.stylist_id).prop("disabled", true);
                        }).fail(function(XMLHttpRequest, textStatus, error){
                            console.log(error);
                        })
                    }
                }
            })
        })
    </script>
</body>
</html>