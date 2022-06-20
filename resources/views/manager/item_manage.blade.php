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
    <h1>商品管理</h1>
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
    @endforeach
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