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
    <h1>FAQ一覧</h1>
    <button onclick="location.href='{{ asset('/manager/faq/create/') }}'">追加</button>
    @foreach ($faqs as $faq)
        <div>
            <p>ID:{{ $faq->id }}</p>
            <p>Q.{{ $faq->question }}</p>
            <p>A.{{ $faq->answer }}</p>
            <button onclick="location.href='{{ asset('/manager/faq/edit/' . $faq->id) }}'">編集</button>
            @if ($faq->exist)
                <button id="delete{{ $faq->id }}" value="{{ $faq->id }}" name="delete">削除</button>
                <button id="recover{{ $faq->id }}" value="{{ $faq->id }}" name="recover" disabled>復旧</button>
            @else
                <button id="delete{{ $faq->id }}" value="{{ $faq->id }}" name="delete" disabled>削除</button>
                <button id="recover{{ $faq->id }}" value="{{ $faq->id }}" name="recover">復旧</button>
            @endif
        </div>
    @endforeach
</body>
<script>
    $(function(){
        $("button").click(function(){
            let name = $(this).attr("name");
            let faq_id = $(this).val();
            if (name == "delete") {
                let delete_flg = window.confirm('本当に削除しますか？');
                if (delete_flg) {
                    $.ajax({
                        type: "get",
                        url: "/manager/faq/delete",
                        data: {"faq_id": faq_id},
                        dataType: "json"
                    }).done(function(data){
                        $("#delete" + data.faq_id).prop("disabled", true);
                        $("#recover" + data.faq_id).prop("disabled", false);
                    }).fail(function(XMLHttpRequest, textStatus, error){
                        console.log(error);
                    })
                }
            } else if (name == "recover") {
                let recover_flg = window.confirm('本当に復旧しますか？');
                if (recover_flg) {
                    $.ajax({
                        type: "get",
                        url: "/manager/faq/recover",
                        data: {"faq_id": faq_id},
                        dataType: "json"
                    }).done(function(data){
                        $("#delete" + data.faq_id).prop("disabled", false);
                        $("#recover" + data.faq_id).prop("disabled", true);
                    }).fail(function(XMLHttpRequest, textStatus, error){
                        console.log(error);
                    })
                }
            }
        })
    })
</script>
</html>