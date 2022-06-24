<!DOCTYPE html>
<html lang="ja">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>和服フリマ（仮）- 検索結果</title>
    <!-- フォント読み込み -->
    <link href="https://fonts.googleapis.com/css2?family=Kaisei+Opti&family=Shippori+Mincho&display=swap" rel="stylesheet">
    <!-- CDN読み込み -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    {{-- ヘッダー --}}
    @include('header');

    <div class="container">
        <div class="contents pt-5 mt-5 w-100 mx-auto text-center">

            {{-- 絞り込み機能 --}}
            <div class="row frima-body">
                <div class="col-6">
                    <input type="checkbox" name="" id="only_on_sale" class=""
                    @if( $onsale === 'true' )
                        checked
                    @endif
                    >
                    <label for="only_on_sale">販売商品のみを表示</label>
                </div>
                <div class="col-3 text-end">
                    <select name="category" id="category">
                        <option value="" selected>未選択</option>
                        @foreach ( $categories as $category )
                        <option value="{{$category}}"
                        @if ( $selected_category == $category )
                            selected
                        @endif
                        >{{$category}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3 text-start">
                    <select name="sort" id="sort">
                        <option value="0"
                        @if ( $sort_type == 0 )
                            selected
                        @endif
                        >出品日時:新しい順</option>
                        
                        <option value="1"
                        @if ( $sort_type == 1 )
                            selected
                        @endif
                        >出品日時:古い順</option>
                        
                        <option value="2"
                        @if ( $sort_type == 2 )
                            selected
                        @endif
                        >値段:高い順</option>
                        
                        <option value="3"
                        @if ( $sort_type == 3 )
                            selected
                        @endif
                        >値段:安い順</option>
                    </select>
                </div>
            </div>

            {{-- 商品一覧 --}}
            <div class="">
                {{-- 表示件数 --}}
                <p class="text-start mt-3">○件中○件</p>

                <!-- 出品中の商品がない場合 -->
                @isset( $msg )
                <div class=" d-flex align-items-center justify-content-center" style="height: 400px;">
                    <p class="text-secondary">{{ $msg }}</p>
                </div>
                @endisset

                <div class="row item_card_wrapper">
                    <span class="col-3 w-25"></span>
                    <span class="col-3 w-25"></span>
                    <span class="col-3 w-25"></span>
                    <span class="col-3 w-25"></span>

                    {{-- 商品カード --}}

                    @foreach ( $item_infos as $item_info )

                    <div id="item_card_{{$item_info['id']}}" 
                         data-is-on-sale="{{$item_info['onsale']==2? 'sold':'sale'}}" 
                         data-category="{{$item_info['category']}}" class="col-sm-3 my-4"
                    >
                        <a href="{{asset('fleamarket/item/' . $item_info['id'] )}}" class="col d-block text-decoration-none">
                            <img src="{{asset($item_info['image'][0]['path'])}}" alt="" class="w-100 ob-fit item_img_size">
                            <p class="text-dark text-start mt-3 mb-2">{{ $item_info["name"] }}</p>
                            <p class="text-dark text-start">￥{{ $item_info["price"] }}</p>
                        </a>
                    </div>

                    @endforeach

                </div>

            </div>

            <!-- ページネーション -->
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item">
                        <a class="page-link border-0" href="#" aria-label="Previous">
                            <span aria-hidden="true" class="link-secondary">&#8249;</span>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link link-secondary border-0" href="#">1</a></li>
                    <li class="page-item"><a class="page-link link-secondary border-0" href="#">2</a></li>
                    <li class="page-item"><a class="page-link link-secondary border-0" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link border-0" href="#" aria-label="Next">
                            <span aria-hidden="true" class="link-secondary">&#8250;</span>
                        </a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>

    {{-- フッター --}}
    @include('footer')

    <script>
        // 販売商品の絞り込みと、カテゴリによる絞り込みのAND検索
        $('#only_on_sale, #category, #sort').change(function() {
            let selected_sortType = $('[name=sort] option:selected').val();
            let is_only_sale = $('#only_on_sale').prop('checked');
            let selected_category = $('[name=category] option:selected').val();
            let search = '?keyword=' + '{{$keyword}}';
            search += '&sort=' + selected_sortType + '&onsale=' + is_only_sale;
            if( selected_category !== '' ){
                search += '&category=' + selected_category;
            }
            let href = location.protocol + '//' + location.host + location.pathname + search;
            location.replace(href);
        });

        const searchItem = function(){
            // それぞれの絞り込み条件の状態を取得
            // チェックされたらtrue, 外れたらfalse
            let is_only_sale = $('#only_on_sale').prop('checked');
            // 選択されたカテゴリ名を格納, 選択されていない場合は'
            let selected_category = $('[name=category] option:selected').val();


            // 全ての商品カードのids
            let all_ids = [];
            // 販売商品絞り込み機能でdisplay:blockとするids
            let display_block_ids_onsale = [];
            // カテゴリ絞り込み機能でdisplay:blockとするids
            let display_block_ids_category = [];




            // 配列に格納する処理
            // 全ての商品カードidを取得
            $('.item_card_wrapper > div').each(function(i, e) {
                let item_id = $(e).attr('id');
                all_ids.push(item_id);
            });
            // 販売商品のチェックボックスに適する商品カードidを取得
            if (is_only_sale) {
                // data-is-on-sale="sale"のものだけ選択する
                $('[data-is-on-sale="sale"]').each(function(i, e) {
                    let item_id = $(e).attr('id');
                    display_block_ids_onsale.push(item_id);
                });
            } else {
                // 全てのカードを選択する
                $('[data-is-on-sale="sale"], [data-is-on-sale="sold"]').each(function(i, e) {
                    let item_id = $(e).attr('id');
                    display_block_ids_onsale.push(item_id);
                });
            }
            // カテゴリに一致する商品カードidを取得
            if (selected_category !== '') {
                // いずれかのカテゴリが選択されている場合
                $('.item_card_wrapper > div[data-category=' + selected_category + ']').each(function(i, e) {
                    let category_id = $(e).attr('id');
                    display_block_ids_category.push(category_id);
                });
            } else {
                // カテゴリの指定がない場合
                all_ids.forEach(function(e, i) {
                    display_block_ids_category.push(e);
                });
            }




            // 両方の配列に存在するidだけ格納する配列
            let display_block_ids = [];
            display_block_ids_onsale.forEach(function(e, i){
                let is_both_exist = false;
                display_block_ids_category.forEach(function(ee, ii){
                    if( e === ee ){
                        is_both_exist = true;
                    }
                });
                if( is_both_exist ){
                    display_block_ids.push( e );
                }
            });
            // display_block_ids以外のidを格納する配列
            let display_none_ids = [];
            all_ids.forEach(function(e, i){
                let is_both_exist = false;
                display_block_ids.forEach(function(ee, ii){
                    if( e === ee ){
                        is_both_exist = true;
                    }
                });
                if( !is_both_exist ){
                    display_none_ids.push( e );
                }
            });

            // cssを適用する
            display_block_ids.forEach(function(e, i) {
                $('#' + e).css('display', 'block');
            });
            display_none_ids.forEach(function(e, i) {
                $('#' + e).css('display', 'none');
            });
        };
    </script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>