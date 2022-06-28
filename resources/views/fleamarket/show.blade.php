<!DOCTYPE html>
<html lang="ja">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>晴 re 着 - 商品詳細</title>
    <link rel="icon" type="image/x-icon" href="{{asset('/image/tagicon.png')}}">    
    <!-- フォント読み込み -->
    <link href="https://fonts.googleapis.com/css2?family=Kaisei+Opti&family=Shippori+Mincho&display=swap" rel="stylesheet">
    <!-- CDN読み込み -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    @php
        $user = unserialize(session()->get("user"));
    @endphp
    {{-- ヘッダー --}}
    @include('header');

    <div class="container">
        <div class="contents pt-5 mt-5 w-100 mx-auto">

            <div class="row mt-5">

                @isset( $msg )
                {{ $msg }}
                @endisset

                <!-- 商品画像スライドショー -->
                <div id="carouselExampleIndicators" class="carousel slide col-sm-6 item-img-size-500" data-bs-ride="carousel">
                    <!-- 下のバー -->
                    <div class="carousel-indicators">
                        @foreach ( $item_info["image"] as $i=> $image)
                        @if ($i == 0)
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        @else
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $i }}" aria-label="Slide {{ $i }}"></button>
                        @endif
                        @endforeach
                    </div>
                    <!-- 画像 -->
                    <div class="carousel-inner">
                        @foreach ( $item_info["image"] as $i=> $image)
                        @if ($i == 0)
                        <div class="carousel-item active">
                            <img src="{{asset($image['path'])}}" class="d-block w-100 ob-fit-cont item-img-size-500" alt="">
                        </div>
                        @else
                        <div class="carousel-item">
                            <img src="{{asset($image['path'])}}" class="d-block w-100 ob-fit-cont item-img-size-500" alt="">
                        </div>
                        @endif
                        @endforeach
                    </div>
                    <!-- 左矢印 -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <!-- 右矢印 -->
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

                <!-- 詳細 -->
                <div class="col-sm-6 p-5">
                    <p class="fs-4">{{ $item_info["name"] }}</p>
                    <p class="fs-5 d-inline">￥{{ number_format($item_info["price"]) }}</p>
                    <!-- <p class="d-inline">（送料：￥400）</p> -->
                    <!-- <p>税込</p> -->
                    <div class="my-3">
                        <p>商品について</p>
                        <div class="row ms-2 border-start">
                            <p class="col-3 mb-0">カテゴリ</p>
                            <p class="col-9 mb-0">{{ $item_info["category"] }}</p>
                            <div class="w-100"></div>
                            <p class="col-3 mb-0">商品状態</p>
                            <p class="col-9 mb-0">{{ $item_info["item_status"] }}</p>
                            <div class="w-100"></div>
                        </div>
                            @if ($user)
                                @if ( $user->id!=$item_info['user_id'] && $item_info['onsale'] == 1 )
                                <div class="bg-secondary-link py-2 my-3 mx-4">
                                    <a href="{{asset('/fleamarket/purchase/'. $item_info['id'])}}'" class="d-block text-center link-light text-decoration-none">購入に進む</a>
                                </div>
                                @elseif( $user->id!=$item_info['user_id'] && $item_info['onsale'] != 1 )
                                    <div class="bg-danger py-2 my-3 mx-4">
                                        <span class="d-block text-center link-light text-decoration-none">売り切れです</span>
                                    </div>
                                @endif
                            @else
                                @if ( $item_info['onsale'] == 1 )
                                <div class="bg-secondary-link py-2 my-3 mx-4">
                                    <a href="{{asset('/fleamarket/purchase/'. $item_info['id'])}}'" class="d-block text-center link-light text-decoration-none">購入に進む</a>
                                </div>
                                @elseif( $item_info['onsale'] != 1 )
                                    <div class="bg-danger py-2 my-3 mx-4">
                                        <span class="d-block text-center link-light text-decoration-none">売り切れです</span>
                                    </div>
                                @endif
                            @endif
                        <div class="ms-2">
                            <div class="">
                                <p class="d-inline">出品日時：</p>
                                <p class="d-inline ps-1">{{$item_info["created_at"]["date"]}}</p>
                            </div>
                            <div class="">
                                <p class="d-inline">発送元：</p>
                                <p class="d-inline ps-1">{{$item_info["area"]}}</p>
                            </div>
                            <div class="">
                                <p class="d-inline">出品者：</p>
                                <p class="d-inline ps-1"><a href="/user/show/{{$item_info['user_info']['id']}}" class="link-dark" target="_blank">{{$item_info["user_info"]["name"]}}</a></p>
                            </div>
                        </div>
                        <div class="d-grid gap-2 my-3 mx-4" id="favorite_btn_wrapper">
                            @if ( $item_info['onsale'] == 1 )
                                @if (isset($is_favorite))
                                    @if ( $is_favorite )
                                    <button id="deleteFavorite" class="btn btn-secondary rounded-0">お気に入りから削除</button>
                                    @else
                                    <button id="insertFavorite" class="btn btn-danger rounded-0">お気に入りに追加</button>
                                    @endif                                
                                    <div id="favorite_messages"></div>
                                @endif
                            @endif
                            {{-- メッセージ表示エリア --}}
                        </div>

                        <!-- コメント欄 -->
                        <p>コメント</p>
                        
                        <div id="comments" class="overflow-auto" style="max-height: 300px;">

                            @foreach ( $item_comments as $item_comment )

                            <div class="row m-0">
                                <div class="col-1 p-0">
                                    <a href="/user/show/{{$item_comment['user_id']}}">
                                        <!-- アイコン -->
                                        <img src="" alt="" class="w-100">
                                    </a>
                                </div>
                                <div class="col-10">
                                    <!-- ユーザ名 -->
                                    @if ( $item_comment['is_seller'] )
                                    <label class="me-1">出品者:</label>
                                    @endif
                                    <a href="/user/show/{{$item_comment['user_id']}}" class="link-dark text-decoration-none my-1 hover-line" target="_blank">{{$item_comment['user_name']}}</a>
                                    <div class="bg-lightoff m-2 rounded p-2">
                                        <!-- コメント本文 -->
                                        <p class="text-break mb-0">{{$item_comment['text']}}</p>
                                        <!-- <p class="text-secondary mb-0 small">13:00</p> -->
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <!-- コメント入力欄 -->
                        <div class="my-2">
                            <textarea name="" id="comment" class="w-100" placeholder="コメントを入力" style="border: solid 1px lightgray;"></textarea>
                        </div>
                        <div class="d-flex">
                            <!-- バリデーションメッセージ -->
                            <p class="text-danger me-auto" id="comment_errors"></p>
                            <div class="justify-content-end">
                                <!-- 送信ボタン -->
                                <button class="btn btn-secondary" id="comment_send">送信</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>


    @include('footer')

    <script>
        // お気に入り追加
        $('body').on('click', '#insertFavorite', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax("/fleamarket/favorite/insert", {
                type: 'post',
                data: {
                    'user_id' : @if($user){{$user->id}}@else''@endif,
                    'item_id': {{$item_info["id"]}}
                },
                dataType: 'json',
                success: function(data) {
                    $('#favorite_btn_wrapper').empty();
                    $('#favorite_btn_wrapper').append('<button id="deleteFavorite" class="btn btn-secondary rounded-0">お気に入りから削除</button>');
                    $('#favorite_btn_wrapper').append('<div id="favorite_messages"></div>');
                    $('#favorite_messages').append('<p>お気に入りに追加しました</p>');
                },
                error: function(error) {
                    $('#favorite_messages').empty();
                    $('#favorite_messages').append('<p>お気に入りに追加出来ませんでした</p>');
                }
            });
        });

        // お気に入りから削除
        $('body').on('click', '#deleteFavorite', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

            $.ajax("/fleamarket/favorite/delete", {
                type: 'post',
                data: {
                    'user_id' : @if($user){{$user->id}}@else''@endif,
                    'item_id': {{$item_info["id"]}}
                },
                dataType: 'json',
                success: function(data) {
                    $('#favorite_btn_wrapper').empty();
                    $('#favorite_btn_wrapper').append('<button id="insertFavorite" class="btn btn-secondary rounded-0 bg-danger">お気に入りに追加</button>');
                    $('#favorite_btn_wrapper').append('<div id="favorite_messages"></div>');
                    $('#favorite_messages').append('<p>お気に入りから削除しました</p>');
                },
                error: function(error) {
                    $('#favorite_messages').empty();
                    $('#favorite_messages').append('<p>お気に入りから削除できませんでした</p>');
                }
            })
        });

        // コメントの追加
        $('#comment_send').click(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax("/fleamarket/item/{{$item_info["id"]}}/upload/comment", {
                    type: 'post',
                    data: {
                        'user_id' : @if($user){{$user->id}}@else''@endif,
                        'comment': $('#comment').val(),
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#comment').val('');
                        $('#comments').empty();
                        
                        for (let i = 0; i < data.length; i++) {
                            let appendElement = '';
                            appendElement += '<div class="row m-0"><div class="col-1 p-0">'
                            appendElement += '<img src="' + '" alt="" class="w-100">'
                            appendElement += '</div>'
                            appendElement += '<div class="col-10">'
                            if (data[i].is_seller) {
                                appendElement += '<label class="me-1">出品者:</label>';
                            }
                            appendElement += '<a href="/user/show/' + data[i].user_id + '" class="link-dark text-decoration-none my-1" target="_blank">' + data[i].user_name + '</a>';
                            appendElement += '<div class="bg-lightoff m-2 rounded p-2"><p class="text-break mb-0">' + data[i].text + '</p></div>';
                            appendElement += '</div></div>'

                            $('#comments').append(appendElement);
                        }
                    },
                    error: function(error) {
                        $('#comment_errors').empty();
                        let errors_obj = JSON.parse(error.responseText).errors;
                        let errors = Object.keys(errors_obj).map(function (key) {return [errors_obj[key]];});;
                        errors.forEach(function(e){
                            $('#comment_errors').append('<p>' + e + '</p>');
                        });
                    }
                }
            )
        });
    </script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>