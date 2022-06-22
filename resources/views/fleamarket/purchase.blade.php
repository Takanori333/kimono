<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>購入</title>
    <style>
        /*モーダル本体の指定 + モーダル外側の背景の指定*/
        .buyer_info_change_modal_container,
        .payment_way_change_modal_container{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            text-align: center;
            background: rgba(0,0,0,50%);
            padding: 40px 20px;
            overflow: auto;
            opacity: 0;
            visibility: hidden;
            transition: .3s;
            box-sizing: border-box;
        }
        /*モーダル本体の擬似要素の指定*/
        .buyer_info_change_modal_container:before,
        .payment_way_change_modal_container:before{
            content: "";
            display: inline-block;
            vertical-align: middle;
            height: 100%;
        }
        /*モーダル本体に「active」クラス付与した時のスタイル*/
        .buyer_info_change_modal_container.active,
        .payment_way_change_modal_container.active{
            opacity: 1;
            visibility: visible;
        }
        /*モーダル枠の指定*/
        .buyer_info_change_modal_body,
        .payment_way_change_modal_body{
            position: relative;
            display: inline-block;
            vertical-align: middle;
            max-width: 500px;
            width: 90%;
        }
        /*モーダルを閉じるボタンの指定*/
        .close_buyer_info_change_modal,
        .close_payment_way_change_modal{
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            top: -40px;
            right: -40px;
            width: 40px;
            height: 40px;
            font-size: 40px;
            color: #fff;
            cursor: pointer;
        }
        /*モーダル内のコンテンツの指定*/
        .modal-content{
            background: #fff;
            text-align: left;
            padding: 30px;
        }
    </style>
</head>
<body>
    {{-- ヘッダー --}}
    {{-- @include(); --}}

    {{-- フリマヘッダー --}}
    <div>
        <div>
            {{-- タイトル --}}
            <h1>商品購入</h1>
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

    {{-- 商品購入 --}}
    <div>
        @isset( $msg )
            {{ $msg }}
        @endisset
        @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
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




                {{-- お届け先 --}}
                <p>お届け先</p>
                <p id="buyer_name">お名前:{{ old('buyer_name', $item_info["user_info"]["name"]) }}</p>
                <p id="buyer_post">郵便番号:{{ old('buyer_post', $item_info["user_info"]["post"]) }}</p>
                <p id="buyer_address">住所:{{ old('buyer_address', $item_info["user_info"]["address"]) }}</p>
                <button class="open_buyer_info_change_modal">変更</button>
                {{-- お届け先変更モーダル --}}
                <div class="buyer_info_change_modal_container">
                    <div class="buyer_info_change_modal_body">
                        {{-- 閉じるボタン --}}
                        <div class="close_buyer_info_change_modal">×</div>
                        {{-- モーダル内のコンテンツ --}}
                        <div class="modal-content">
                            {{-- お届け先名前 --}}
                            <label for="modal_buyer_name">お名前:</label>
                            <input type="text" id="modal_buyer_name" value="{{ old('buyer_name', $item_info["user_info"]["name"]) }}"><br>
                            {{-- お届け先郵便番号 --}}
                            <label for="modal_buyer_post">郵便番号:</label>
                            <input type="text" id="modal_buyer_post" value="{{ old('buyer_post', $item_info["user_info"]["post"]) }}"><br>
                            {{-- お届け先住所 --}}
                            <label for="modal_buyer_address">住所:</label><br>
                            <textarea id="modal_buyer_address" cols="30" rows="10">{{ old('buyer_address', $item_info["user_info"]["address"]) }}</textarea><br>
                            <button id="buyer_info_change">変更</button>
                        </div>
                    </div>
                </div>



                {{-- お支払い方法 --}}
                <p>お支払い方法:</p>
                <p id="payment_way">{{ old('payment_way') }}</p>
                <button class="open_payment_way_change_modal">変更</button>
                {{-- お支払い方法モーダル --}}
                <div class="payment_way_change_modal_container">
                    <div class="payment_way_change_modal_body">
                        {{-- 閉じるボタン --}}
                        <div class="close_payment_way_change_modal">×</div>
                        {{-- モーダル内のコンテンツ --}}
                        <div class="modal-content">
                            <label for="cash_on_delivery">代引き</label>
                            <input type="radio" id="cash_on_delivery" name="payment_way" value="代引き" {{ old('payment_way') == '代引き' ? 'checked' : '' }}><br>
                            <label for="credit_card">クレジットカード</label>
                            <input type="radio" id="credit_card" name="payment_way" value="クレジットカード" {{ old('payment_way') == 'クレジットカード' ? 'checked' : '' }}><br>
                            <label for="convenience_payment">コンビニ払い</label>
                            <input type="radio" id="convenience_payment" name="payment_way" value="コンビニ払い" {{ old('payment_way') == 'コンビニ払い' ? 'checked' : '' }}><br>
                            <button id="payment_way_change">変更</button>
                        </div>
                    </div>
                </div>





                <form action="/fleamarket/purchase/confirm/{{$item_info['id']}}" method="POST">
                    @csrf
                    <input type="hidden" name="buyer_name" id="hidden_buyer_name" value="{{ old('buyer_name', $item_info["user_info"]["name"]) }}">
                    <input type="hidden" name="buyer_post" id="hidden_buyer_post" value="{{ old('buyer_post', $item_info["user_info"]["post"]) }}">
                    <input type="hidden" name="buyer_address" id="hidden_buyer_address" value="{{ old('buyer_address', $item_info["user_info"]["address"]) }}">
                    <input type="hidden" name="payment_way" id="hidden_payment_way" value="{{ old('payment_way') }}">
                    <button type="submit">購入</button>
                </form>
            </div>
        </div>
    </div>


    <script>
        $(function(){
            // 変数に要素を入れる
            let open_bicm = $('.open_buyer_info_change_modal');
            let close_bicm = $('.close_buyer_info_change_modal');
            let container_bicm = $('.buyer_info_change_modal_container');
            let open_pwcm = $('.open_payment_way_change_modal');
            let close_pwcm = $('.close_payment_way_change_modal');
            let container_pwcm = $('.payment_way_change_modal_container');

            // 開くボタンをクリックしたらモーダルを表示する
            open_bicm.on('click',function(){	
                container_bicm.addClass('active');
                return false;
            });
            open_pwcm.on('click',function(){	
                container_pwcm.addClass('active');
                return false;
            });

            // 閉じるボタンをクリックしたらモーダルを閉じる
            close_bicm.on('click',function(){	
                container_bicm.removeClass('active');
            });
            close_pwcm.on('click',function(){	
                container_pwcm.removeClass('active');
            });

            // モーダルの外側をクリックしたらモーダルを閉じる
            $(document).on('click',function(e) {
                if(!$(e.target).closest('.buyer_info_change_modal_body').length) {
                    let buyer_name = $('#hidden_buyer_name').val();
                    let buyer_post = $('#hidden_buyer_post').val();
                    let buyer_address = $('#hidden_buyer_address').val();

                    $('#modal_buyer_name').val(buyer_name);
                    $('#modal_buyer_post').val(buyer_post);
                    $('#modal_buyer_address').val(buyer_address);

                    container_bicm.removeClass('active');
                }

                if(!$(e.target).closest('.payment_way_change_modal_body').length) {
                    let payment_way = $('#hidden_payment_way').val();
                    if( payment_way === '' ){
                        $('input:radio[name="payment_way"]').prop('checked',false);
                    }else{
                        $('input:radio[name="payment_way"]').prop('checked',false);
                        $('input:radio[name="payment_way"]').val([payment_way]);
                    }

                    container_pwcm.removeClass('active');
                }
            });

            // お届け先の変更を確定したら対応個所をすべて変更してモーダルを閉じる
            $('#buyer_info_change').on('click', function(){
                let buyer_name = $('#modal_buyer_name').val();
                let buyer_post = $('#modal_buyer_post').val();
                let buyer_address = $('#modal_buyer_address').val();

                $('#buyer_name').text('お名前:' + buyer_name);
                $('#hidden_buyer_name').val(buyer_name);
                $('#buyer_post').text('郵便番号:' + buyer_post);
                $('#hidden_buyer_post').val(buyer_post);
                $('#buyer_address').text('住所:' + buyer_address);
                $('#hidden_buyer_address').val(buyer_address);

                container_bicm.removeClass('active');
            });

            // 支払い方法の変更が確定したら対応個所をすべて変更してモーダルを閉じる
            $('#payment_way_change').on('click', function(){
                let selected_payment_way = $('input:radio[name="payment_way"]:checked').val();

                $('#payment_way').text(selected_payment_way);
                $('#hidden_payment_way').val(selected_payment_way);

                container_pwcm.removeClass('active');
            });
        });
    </script>
</body>
</html>