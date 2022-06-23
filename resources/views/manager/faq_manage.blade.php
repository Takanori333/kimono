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
    {{-- <h1>FAQ一覧</h1>
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
    @endforeach --}}
    @include('header')
    <div class="container">
        <div class="contents pt-5 mt-5 w-100 mx-auto text-center">
            <h1>FAQ一覧</h1>
            <!-- 商品一覧 -->
            <div class="">
                <div class="text-center my-4 py-5">
                    <button class="btn btn-outline-success" onclick="location.href='{{ asset('/manager/faq/create/') }}'" style="width: 100px">追加</button>
                    @foreach ($faqs as $faq)
                    <div class="w-75 row m-0 mx-auto border_shadow my-4">
                        <div class="row">
                            <div class="col-1 text-start my-3">ID:{{ $faq->id }}</div>
                            <div class="col">
                                <div class="row text-break text-start h5 m-3">Q.{{ $faq->question }}</div>
                                <div class="row text-break text-start h5 m-3">A.{{ $faq->answer }}</div>
                            </div>    
                        </div>
                        <div class="row d-flex justify-content-center mb-3 w-100">
                            <button class="btn btn-outline-primary px-3 mt-4 mx-1 col-3" onclick="location.href='{{ asset('/manager/faq/edit/' . $faq->id) }}'">編集</button>
                            @if ($faq->exist)
                            <button class="btn btn-outline-danger px-3 mt-4 mx-1 col-3" id="delete{{ $faq->id }}" value="{{ $faq->id }}" name="delete">削除</button>
                            <button class="btn btn-outline-secondary px-3 mt-4 mx-1 col-3" id="recover{{ $faq->id }}" value="{{ $faq->id }}" name="recover" disabled>復旧</button>
                            @else
                            <button class="btn btn-outline-danger px-3 mt-4 mx-1 col-3" id="delete{{ $faq->id }}" value="{{ $faq->id }}" name="delete" disabled>削除</button>
                            <button class="btn btn-outline-secondary px-3 mt-4 mx-1 col-3" id="recover{{ $faq->id }}" value="{{ $faq->id }}" name="recover">復旧</button>
                            @endif            
                        </div>
                    </div>  
                    @endforeach                                        
                </div>    
            </div>
        </div>
    </div>
    @include('footer')

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