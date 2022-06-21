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
    <h1>スタイリスト管理</h1>
    @foreach ($stylists as $stylist)
        <div>
            <img src="{{ asset($stylist->stylist_info->icon) }}" alt="">
            <br>
            <a href="{{ asset('/stylist/show/' . $stylist->id) }}">{{ $stylist->stylist_info->name }}</a>
            @if ($stylist->stylist_info->sex)
                <p>男</p>
            @else
                <p>女</p>
            @endif
            <p>{{ str_replace('-', '/', $stylist->stylist_info->birthday) }}</p>
            <p>{{ $stylist->email }}</p>
            <p>{{ $stylist->stylist_info->phone }}</p>
            <p>{{ $stylist->stylist_info->post }}</p>
            <p>{{ $stylist->stylist_info->address }}</p>
            <p>評価:{{ $stylist->stylist_comment->avg("point") }}</p>
            <p>対応地域:
                @foreach ($stylist->stylist_area as $stylist_area)
                    <span>{{ $stylist_area->area }}</span>
                @endforeach
            </p>
            @if ($stylist->exist == 1)
                <button id="delete{{ $stylist->id }}" value="{{ $stylist->id }}" class="manage" name="delete">削除</button>
                <button id="recover{{ $stylist->id }}" value="{{ $stylist->id }}" class="manage" name="recover" disabled>復旧</button>
            @else
                <button id="delete{{ $stylist->id }}" value="{{ $stylist->id }}" class="manage" name="delete" disabled>削除</button>
                <button id="recover{{ $stylist->id }}" value="{{ $stylist->id }}" class="manage" name="recover">復旧</button>
            @endif
        </div>
    @endforeach
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