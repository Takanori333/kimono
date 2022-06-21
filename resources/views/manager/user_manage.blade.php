<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <h1>ユーザー管理</h1>
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
    @endforeach
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