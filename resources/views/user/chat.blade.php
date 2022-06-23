<!doctype html>
<html lang="ja">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>和服フリマ（仮） - フリマ</title>
    <!-- フォント読み込み -->
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/my-sheet.css') }}">
    <!-- CDN読み込み -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body>
    @include('header')
    <div class="container p-5 mt-5">
        <div class="row mt-5">
            <div class="col-12 col-xxl-6 col-xl-6 my-2">
                <div>
                    <div class="list-group overflow-auto " style="height: 400px">
                        <li class="list-group-item list-group-item-secondary text-center">フリーマチャット</li>
                        @foreach ($trade_chat as $chat)
                        <a href="{{ asset("/user/trade_chat/".$chat->item_id) }}" class="list-group-item list-group-item-action d-flex justify-content-between" aria-current="true" target="_blank">
                            <div><img src="{{ asset("$chat->icon") }}" alt="" width="25px" height="25px">{{ $chat->name }}</div>
                            <div>商品：{{ $chat->item_name }}</div>
                            @if ($chat->readed)
                                <span class="badge bg-danger rounded-pill" style="height: 21px">{{ $chat->readed }}</span>                                
                            @else
                                <span></span>
                            @endif
                        </a>                                              
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-12 col-xxl-6 col-xl-6 my-2">
                <div>
                    <div class="list-group  overflow-auto" style="height: 400px">
                        <li class="list-group-item list-group-item-secondary text-center">スタイリストチャット</li>
                        @foreach ($stylist_chat as $chat)
                        <a href="{{ asset("/user/stylist_chat/".$chat->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between" aria-current="true" target="_blank">
                            <div><img src="{{ asset("$chat->icon") }}" alt="" width="25px" height="25px">{{ $chat->name }}</div>
                            @if ($chat->readed)
                                <span class="badge bg-danger rounded-pill"  style="height: 21px">{{ $chat->readed }}</span>                                
                            @endif
                          </a>                                              
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
</body>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</html>