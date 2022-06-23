<!DOCTYPE html>
<html lang="ja">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Kaisei+Opti&family=Shippori+Mincho&display=swap"
        rel="stylesheet">
    <!-- CDN読み込み -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>和服フリマ（仮）- 購入</title>
    <style>
        /*モーダル本体の指定 + モーダル外側の背景の指定*/
        /* .buyer_info_change_modal_container,
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
        } */
        /*モーダル本体の擬似要素の指定*/
        /* .buyer_info_change_modal_container:before,
        .payment_way_change_modal_container:before{
            content: "";
            display: inline-block;
            vertical-align: middle;
            height: 100%;
        } */
        /*モーダル本体に「active」クラス付与した時のスタイル*/
        /*.buyer_info_change_modal_container.active,
        .payment_way_change_modal_container.active{
            opacity: 1;
            visibility: visible;
        }*/
        /*モーダル枠の指定*/
        /* .buyer_info_change_modal_body,
        .payment_way_change_modal_body{
            position: relative;
            display: inline-block;
            vertical-align: middle;
            max-width: 500px;
            width: 90%;
        } */
        /*モーダルを閉じるボタンの指定*/
        /* .close_buyer_info_change_modal,
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
        } */
        /*モーダル内のコンテンツの指定*/
        /* .modal-content{
            background: #fff;
            text-align: left;
            padding: 30px;
        } */
    </style>
</head>
<body>
    {{-- ヘッダー --}}
    @include('header');

    <div class="container">
        <div class="contents pt-5 mt-5 w-100 mx-auto">

            <div class="row mt-5">

                @isset( $msg )
                {{ $msg }}
                @endisset
                @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            
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
                            <img src="{{asset($image['path'])}}" class="d-block w-100 ob-fit item-img-size-500" alt="">
                        </div>
                        @else
                        <div class="carousel-item">
                            <img src="{{asset($image['path'])}}" class="d-block w-100 ob-fit item-img-size-500" alt="">
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
                    <p class="fs-5 d-inline">￥{{ $item_info["price"] }}</p>
                    <!-- <p class="d-inline">（送料：￥400）</p> -->
                    <!-- <p>税込</p> -->
                    <div class="my-3 row">
                        <p class="me-2 col-sm-2 m-1">お届け先</p>
                        <div class="col-sm">
                            <p class="mb-0" id="buyer_name">{{ old('buyer_name', $item_info["user_info"]["name"]) }}</p>
                            <p class="mb-0" id="buyer_post">〒{{ old('buyer_post', $item_info["user_info"]["post"]) }}</p>
                            <p class="mb-0" id="buyer_address">{{ old('buyer_address', $item_info["user_info"]["address"]) }}</p>
                        </div>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-secondary rounded-0 open_buyer_info_change_modal" type="button" data-bs-toggle="modal" data-bs-target="#userInfoModal">変更</button>
                    </div>

                    <!-- モーダル -->
                    <div class="modal fade close_buyer_info_change_modal" id="userInfoModal" tabindex="-1" aria-labelledby="userInfoModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="userInfoModalLabel">お届け先変更</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- バリデーションメッセージ -->
                                    <!-- <p class="text-danger">バリデーションメッセージ</p> -->
                                    <form>
                                        <div class="mb-3">
                                            <label for="modal_buyer_name" class="col-form-label">お名前</label>
                                            <input type="text" id="modal_buyer_name" class="form-control" value="{{ old('buyer_name', $item_info['user_info']['name']) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="modal_buyer_post" class="col-form-label">郵便番号</label>
                                            <input type="text" id="modal_buyer_post" class="form-control" value="{{ old('buyer_post', $item_info['user_info']['post']) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="modal_buyer_address" class="col-form-label">住所</label>
                                            <textarea name="" id="modal_buyer_address" cols="20" rows="10" class="form-control">{{ old('buyer_address', $item_info["user_info"]["address"]) }}</textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">キャンセル</button>
                                    <button type="submit" class="btn btn-secondary" id="buyer_info_change" data-bs-dismiss="modal">確定</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="my-3 row">
                        <p class="me-2 col-sm-2 m-1 pe-0">お支払方法</p>
                        <div class="col-sm mt-1">
                            <p class="mb-0" id="payment_way">{{ old('payment_way') }}</p>
                        </div>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-secondary rounded-0 open_payment_way_change_modal" type="button" data-bs-toggle="modal" data-bs-target="#howPayModal">変更</button>
                    </div>

                    <!-- モーダル -->
                    <div class="modal fade payment_way_change_modal_container" id="howPayModal" tabindex="-1" aria-labelledby="howPayModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="howPayModalLabel">お支払方法変更</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body payment_way_change_modal_body">
                                    <!-- バリデーションメッセージ -->
                                    <!-- <p class="text-danger">バリデーションメッセージ</p> -->
                                    <form>
                                        <div class="mb-3">
                                            <div class="col-sm py-2">
                                                <input type="radio" class="form-check-input" id="cash_on_delivery" name="payment_way" value="代引き" {{ old('payment_way') == '代引き' ? 'checked' : '' }}>
                                                <label class="d-inline me-3" for="cash_on_delivery">代引き</label>
                                                <input type="radio" class="form-check-input" id="credit_card" name="payment_way" value="クレジットカード" {{ old('payment_way') == 'クレジットカード' ? 'checked' : '' }}>
                                                <label class="d-inline me-3" for="credit_card">クレジットカード</label>
                                                <input type="radio" class="form-check-input" id="convenience_payment" name="payment_way" value="コンビニ払い" {{ old('payment_way') == 'コンビニ払い' ? 'checked' : '' }}>
                                                <label class="d-inline me-3" for="convenience_payment">コンビニ支払い</label>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">キャンセル</button>
                                    <button type="submit" class="btn btn-secondary" id="payment_way_change"  data-bs-dismiss="modal">確定</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="/fleamarket/purchase/confirm/{{$item_info['id']}}" method="POST">
                        @csrf
                        <input type="hidden" name="buyer_name" id="hidden_buyer_name" value="{{ old('buyer_name', $item_info['user_info']['name']) }}">
                        <input type="hidden" name="buyer_post" id="hidden_buyer_post" value="{{ old('buyer_post', $item_info['user_info']['post']) }}">
                        <input type="hidden" name="buyer_address" id="hidden_buyer_address" value="{{ old('buyer_address', $item_info['user_info']['address']) }}">
                        <input type="hidden" name="payment_way" id="hidden_payment_way" value="{{ old('payment_way') }}">
                        <div class="d-grid gap-2 my-3 mx-4">
                            <button class="btn btn-secondary rounded-0" type="submit">購入</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>


    <!-- {{-- 商品購入 --}}
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

            </div>
        </div>
    </div> -->

    @include('footer')

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
                        $('input:radio[class="form-check-input"]').prop('checked',false);
                    }else{
                        $('input:radio[class="form-check-input"]').prop('checked',false);
                        $('input:radio[class="form-check-input"]').val([payment_way]);
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

                // container_bicm.removeClass('active');
            });

            // 支払い方法の変更が確定したら対応個所をすべて変更してモーダルを閉じる
            $('#payment_way_change').on('click', function(){
                let selected_payment_way = $('input:radio[class="form-check-input"]:checked').val();

                $('#payment_way').text(selected_payment_way);
                $('#hidden_payment_way').val(selected_payment_way);

                // container_pwcm.removeClass('active');
            });
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