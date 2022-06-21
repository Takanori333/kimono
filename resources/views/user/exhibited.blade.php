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
    <h1>出品中の商品</h1>
    <button onclick="location.href='{{ asset('/fleamarket/exhibit/new') }}'">出品する</button>
    <p>{{ $msg }}</p>
    @if ($exhibited_items->isNotEmpty())
        @foreach ($exhibited_items as $exhibited_item)
            <div>
                <img src="{{ asset($exhibited_item->item_photo->first()->path) }}" alt="">
                <br>
                <a href="{{ asset('/fleamarket/item/'. $exhibited_item->id) }}">{{ $exhibited_item->item_info->name }}</a>
                <p>{{ number_format($exhibited_item->item_info->price) }}円</p>
                <button onclick="location.href='{{ asset('/fleamarket/item/edit/'. $exhibited_item->id) }}'">編集する</button>
                <button name="delete" value="{{ $exhibited_item->id }}" class="delete">削除する</button>
            </div>
        @endforeach
    @else
        <p>出品している商品はありません</p>
    @endif
    <script>
        $(function(){
            $(".delete").click(function(){
            let id = $(this).val();
                let delete_flg = window.confirm('本当に削除しますか？');
                if (delete_flg) {
                    window.location.href = `/user/exhibited/delete/${id}`;
                    // $.ajax({
                    //     type: "get",
                    //     url: "/user/exhibited/delete/",
                    //     data: {"id": id},
                    //     dataType: "json"
                    // })
                    // // .done(function(data){
                    // //     $("#delete" + data.stylist_id).prop("disabled", true);
                    // //     $("#recover" + data.stylist_id).prop("disabled", false);
                    // // })
                    // .fail(function(XMLHttpRequest, textStatus, error){
                    //     console.log(error);
                    // })
                }
            })
        })
    </script>
</body>
</html>