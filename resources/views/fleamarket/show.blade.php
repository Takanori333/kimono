<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>商品詳細</title>
</head>
<body>
    {{-- ヘッダー --}}
    {{-- @include(); --}}

    {{-- フリマヘッダー --}}
    <div>
        {{-- 検索窓 --}}
        <div>
            {{-- タイトル --}}
            <h1>商品詳細</h1>
            <p>検索</p>
            <form action="/fleamarket/search" method="GET">
                <input type="text" name="keyword">
                <input type="submit" value="🔍">
            </form>
        </div>
        {{-- お気に入り商品閲覧ページ --}}
        @if ( session('user') )
            <a href="{{asset("/fleamarket/favorite")}}">お気に入り商品</a>
        @endif
        {{-- 出品ボタン --}}
        <a href="{{asset("/fleamarket/exhibit/new")}}">出品</a>
    </div>

    {{-- 商品詳細 --}}
    <div>
        @isset( $msg )
            {{ $msg }}
        @endisset
        {{-- 商品画像 --}}
        <div>
            @foreach ( $item_info["image"] as $image )
                <img src="{{asset($image["path"])}}">
            @endforeach
        </div>
        {{-- 商品情報, 購入ボタン, お気に入りボタン, チャット --}}
        <div>
            {{-- 商品情報, 購入・お気に入りボタン --}}
            <div>
                {{-- 商品名 --}}
                <p>{{ $item_info["name"] }}</p>
                {{-- 値段 --}}
                <p>￥{{ $item_info["price"] }}</p>
                {{-- 商品について --}}
                <p>商品について</p>
                <p>カテゴリ: {{ $item_info["category"] }}</p>
                <p>商品状態: {{ $item_info["item_status"] }}</p>
                {{-- 購入ボタン --}}
                <button onclick="location.href='{{asset('/fleamarket/purchase/'. $item_info['id'])}}'">購入に進む</button>

                {{-- その他商品情報 --}}
                <p>出品日時: {{$item_info["created_at"]["date"]}}</p>
                <p>発送元: {{$item_info["area"]}}</p>
                <p>出品者: <a href="/user/show/{{$item_info["user_info"]["id"]}}">{{$item_info["user_info"]["name"]}}</a></p>
                {{-- お気に入りに追加ボタン --}}
                <div id="favorite_btn_wrapper">
                    @if ( $is_favorite )
                        <button id="deleteFavorite">お気に入りから削除</button>
                    @else
                        <button id="insertFavorite">お気に入りに追加</button>
                    @endif
                    {{-- メッセージ表示エリア --}}
                    <div id="favorite_messages"></div>
                </div>
            </div>

            {{-- チャット欄 --}}
            <p>コメント</p>
            <div id="comments">
            @foreach ( $item_comments as $item_comment )
                <p>
                    @if ( $item_comment['is_seller'] )
                        出品者:
                    @endif
                    <a href="/user/show/{{$item_comment['user_id']}}">
                        {{$item_comment['user_name']}}
                    </a>>{{$item_comment['text']}}
                </p>
            @endforeach
            </div>
            {{-- テキスト入力欄 --}}
            <textarea id="comment" cols="30" rows="2"></textarea><br>
            {{-- エラーメッセージ --}}
            <div id="comment_errors"></div>
            {{-- 送信ボタン --}}
            <button id="comment_send">送信</button>
        </div>
    </div>
    <script>
        // お気に入り追加
        $('body').on('click', '#insertFavorite', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax("/fleamarket/favorite/insert",
                {
                    type: 'post',
                    data: {
                        'item_id' : {{ $item_info["id"] }}
                    },
                    dataType: 'json',
                    success:function(data){
                        $('#favorite_btn_wrapper').empty();
                        $('#favorite_btn_wrapper').append('<button id="deleteFavorite">お気に入りから削除</button>');
                        $('#favorite_btn_wrapper').append('<div id="favorite_messages"></div>');
                        $('#favorite_messages').append('<p>お気に入りに追加しました</p>');
                    },
                    error:function(error){
                        $('#favorite_messages').empty();
                        $('#favorite_messages').append('<p>お気に入りに追加出来ませんでした</p>');
                    }
                }
            )
        });

        // お気に入りから削除
        $('body').on('click', '#deleteFavorite', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax("/fleamarket/favorite/delete",
                {
                    type: 'post',
                    data: {
                        'item_id' : {{ $item_info["id"] }}
                    },
                    dataType: 'json',
                    success:function(data){
                        $('#favorite_btn_wrapper').empty();
                        $('#favorite_btn_wrapper').append('<button id="insertFavorite">お気に入りに追加</button>');
                        $('#favorite_btn_wrapper').append('<div id="favorite_messages"></div>');
                        $('#favorite_messages').append('<p>お気に入りから削除しました</p>');
                    },
                    error:function(error){
                        $('#favorite_messages').empty();
                        $('#favorite_messages').append('<p>お気に入りから削除できませんでした</p>');
                    }
                }
            )
        });

        // コメントの追加
        $('#comment_send').click(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $.ajax("/fleamarket/item/{{$item_info["id"]}}/upload/comment",
                {
                    type: 'post',
                    data: {
                        'comment' : $('#comment').val() 
                    },
                    dataType: 'json',
                    success:function(data){
                        $('#comment').val('');
                        $('#comments').empty();
                        for(let i=0;i<data.length;i++){
                            let appendElement = '';
                            appendElement += '<p>'
                            if( data[i].is_seller ){
                                appendElement += '出品者:';
                            }
                            appendElement += '<a href="/user/show/' + data[i].user_id + '">' + data[i].user_name + '</a>';
                            appendElement += '>' + data[i].text;
                            appendElement += '</p>'

                            $('#comments').append(appendElement);
                        }
                    },
                    error:function(error){
                        $('#comment_errors').empty();
                        $('#comment_errors').append('<p>' + error.responseJSON.message +'</p>');
                    }
                }
            )
        });
    </script>
</body>
</html>