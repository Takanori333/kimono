<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>商品一覧</title>
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

</head>
<body>
    {{-- <h1>商品管理</h1>


    @foreach ($items as $item)
        <div>
            <img src="{{ asset($item->item_photo->first()->path) }}" alt="">
            <br>
            <a href="{{ asset('/fleamarket/item/'. $item->id) }}">{{ $item->item_info->name }}</a>
            <p>{{ number_format($item->item_info->price) }}円</p>
            <p>発送元:{{ $item->item_info->area }}</p>
            <a href="{{ asset('/user/show/' . $item->user_id) }}">{{ $item->user_info->name }}</a>
            <p>{{ str_replace('-', '/', $item->created_at) }}</p>
            <p>{{ $item->detail }}</p>
            @if ($item->onsale)
                <button id="delete{{ $item->id }}" value="{{ $item->id }}" name="delete">削除</button>
                <button id="recover{{ $item->id }}" value="{{ $item->id }}" name="recover" disabled>復旧</button>
            @else
                <button id="delete{{ $item->id }}" value="{{ $item->id }}" name="delete" disabled>削除</button>
                <button id="recover{{ $item->id }}" value="{{ $item->id }}" name="recover">復旧</button>
            @endif
        </div>
    @endforeach --}}
    @include('header')
    <div class="container">
        <div class="contents pt-5 mt-5 w-100 mx-auto text-center">
            <h1>商品管理</h1>
            <!-- 商品一覧 -->
            <div class="">
                <div class="text-center my-4 py-5">
                    @foreach ($items as $item)
                    <div class="w-75 row m-0 mx-auto border_shadow my-4">
                        <img src="{{ asset($item->item_photo->first()->path) }}" alt="" width="263px" height="263px" class="col w-25 p-0">
                        <div class="col-sm d-grid gap-1">
                            <div class="mx-3 mt-4 text-start">
                                <a href="{{ asset('/fleamarket/item/'. $item->id) }}" class="link-dark text-decoration-none h4">{{ $item->item_info->name }}</a>
                            </div>
                            <p class="m-3 text-start">￥{{ number_format($item->item_info->price) }}</p>
                            <p class="m-3 text-start">発送元　{{ $item->item_info->area }}</p>
                            <p class="m-3 text-start">
                                <a href="{{ asset('/user/show/' . $item->user_id) }}" class="link-dark text-decoration-none h4">{{ $item->user_info->name }}</a>
                            </p>
                        </div>
                        <div class="col my-3 d-flex flex-column justify-content-between">
                            <p class="m-3 text-start">{{ str_replace('-', '/', $item->created_at) }}</p>
                            <p class="m-3 text-start text-break">{{ $item->detail }}</p>
                            <div class="row d-flex justify-content-center">
                                @if ($item->onsale)
                                    <button class="btn btn-outline-danger px-3 mt-4 mx-1 col-5" id="delete{{ $item->id }}" value="{{ $item->id }}" name="delete">削除</button>
                                    <button class="btn btn-outline-secondary px-3 mt-4 mx-1 col-5" id="recover{{ $item->id }}" value="{{ $item->id }}" name="recover" disabled>復旧</button>
                                @else
                                    <button class="btn btn-outline-danger px-3 mt-4 mx-1 col-5" id="delete{{ $item->id }}" value="{{ $item->id }}" name="delete" disabled>削除</button>
                                    <button class="btn btn-outline-secondary px-3 mt-4 mx-1 col-5" id="recover{{ $item->id }}" value="{{ $item->id }}" name="recover">復旧</button>
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
            $("button").click(function(){
                let name = $(this).attr("name");
                let item_id = $(this).val();
                if (name == "delete") {
                    let delete_flg = window.confirm('本当に削除しますか？');
                    if (delete_flg) {
                        $.ajax({
                            type: "get",
                            url: "/manager/item/delete",
                            data: {"item_id": item_id},
                            dataType: "json"
                        }).done(function(data){
                            $("#delete" + data.item_id).prop("disabled", true);
                            $("#recover" + data.item_id).prop("disabled", false);
                        }).fail(function(XMLHttpRequest, textStatus, error){
                            console.log(error);
                        })
                    }
                } else if (name == "recover") {
                    let recover_flg = window.confirm('本当に復旧しますか？');
                    if (recover_flg) {
                        $.ajax({
                            type: "get",
                            url: "/manager/item/recover",
                            data: {"item_id": item_id},
                            dataType: "json"
                        }).done(function(data){
                            $("#delete" + data.item_id).prop("disabled", false);
                            $("#recover" + data.item_id).prop("disabled", true);
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