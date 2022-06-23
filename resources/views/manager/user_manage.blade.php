<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>和服フリマ（仮） - フリマ</title>
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

</head>
<body>
    {{-- <h1>ユーザー管理</h1>
    @foreach ($users as $user)
        <div>
            <img src="{{ asset($user->user_info->icon) }}" alt="">
            <br>
            <a href="{{ asset('/user/show/' . $user->id) }}">{{ $user->user_info->name }}</a>
            @if ($user->user_info->sex)
                <p>男</p>
            @else
                <p>女</p>
            @endif
            <p>{{ str_replace('-', '/', $user->user_info->birthday) }}</p>
            <p>{{ $user->email }}</p>
            <p>{{ $user->user_info->phone }}</p>
            <p>{{ $user->user_info->post }}</p>
            <p>{{ $user->user_info->address }}</p>
            @if ($user->exist)
                <button id="delete{{ $user->id }}" value="{{ $user->id }}" class="manage" name="delete">削除</button>
                <button id="recover{{ $user->id }}" value="{{ $user->id }}" class="manage" name="recover" disabled>復旧</button>
            @else
                <button id="delete{{ $user->id }}" value="{{ $user->id }}" class="manage" name="delete" disabled>削除</button>
                <button id="recover{{ $user->id }}" value="{{ $user->id }}" class="manage" name="recover">復旧</button>
            @endif
        </div>
    @endforeach --}}
    @include('header')
    <div class="container">
        <div class="contents pt-5 mt-5 w-100 mx-auto text-center">
            <h1>ユーザー管理</h1>
            <!-- 商品一覧 -->
            <div class="">
                @foreach ($users as $user)                
                <div class="text-center my-4">
                    <div class="w-75 row m-0 mx-auto border_shadow my-4">
                        <img src="{{ asset($user->user_info->icon) }}" alt="" class="col w-25 p-0" width="263px" height="263px">
                        <div class="col-sm d-grid gap-1">
                            <div class="mx-3 mt-3 text-start">
                                <a href="{{ asset('/user/show/' . $user->id) }}" class="link-dark text-decoration-none h4">{{ $user->user_info->name }}</a>
                            </div>
                            <p class="m-3 text-start col">@if($user->user_info->sex)男@else 女@endif {{ str_replace('-', '/', $user->user_info->birthday) }}</p>
                            <p class="m-3 text-start">{{ $user->email }}</p>
                            <p class="m-3 text-start">{{ $user->user_info->phone }}</p>
                        </div>
                        <div class="col my-3 d-flex flex-column justify-content-between">
                                <p class="m-3 text-start">{{ $user->user_info->post }}</p>
                                <p class="m-3 text-start text-break">{{ $user->user_info->address }}</p>
                                <div class="row d-flex justify-content-center">
                                    @if ($user->exist)
                                    <button class="btn btn-outline-danger px-3 mt-4 mx-1 col-5 manage" id="delete{{ $user->id }}" value="{{ $user->id }}" name="delete">削除</button>
                                    <button class="btn btn-outline-secondary px-3 mt-4 mx-1 col-5 manage" id="recover{{ $user->id }}" value="{{ $user->id }}" name="recover" disabled>復旧</button>
                                @else
                                    <button class="btn btn-outline-danger px-3 mt-4 mx-1 col-5 manage" id="delete{{ $user->id }}" value="{{ $user->id }}" name="delete" disabled>削除</button>
                                    <button class="btn btn-outline-secondary px-3 mt-4 mx-1 col-5 manage" id="recover{{ $user->id }}" value="{{ $user->id }}" name="recover">復旧</button>
                                @endif
                            </div>
                        </div>
                    </div>            
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @include('footer')        
    <script>
        $(function(){
            $(".manage").click(function(){
                let name = $(this).attr("name");
                let user_id = $(this).val();
                if (name == "delete") {
                    let delete_flg = window.confirm('本当に削除しますか？');
                    if (delete_flg) {
                        $.ajax({
                            type: "get",
                            url: "/manager/user/delete",
                            data: {"user_id": user_id},
                            dataType: "json"
                        }).done(function(data){
                            $("#delete" + data.user_id).prop("disabled", true);
                            $("#recover" + data.user_id).prop("disabled", false);
                        }).fail(function(XMLHttpRequest, textStatus, error){
                            console.log(error);
                        })
                    }
                } else if (name == "recover") {
                    let recover_flg = window.confirm('本当に復旧しますか？');
                    if (recover_flg) {
                        $.ajax({
                            type: "get",
                            url: "/manager/user/recover",
                            data: {"user_id": user_id},
                            dataType: "json"
                        }).done(function(data){
                            $("#delete" + data.user_id).prop("disabled", false);
                            $("#recover" + data.user_id).prop("disabled", true);
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