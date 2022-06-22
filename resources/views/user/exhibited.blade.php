<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>和服フリマ（仮）- 商品一覧</title>
    <!-- フォント読み込み -->
    <link href="https://fonts.googleapis.com/css2?family=Kaisei+Opti&family=Shippori+Mincho&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/my-sheet.css') }}">
    <!-- CDN読み込み -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="{{ asset('js/header.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>

    @include('header')

    <div class="container">
        <div class="contents pt-5 mt-5 w-75 mx-auto text-center">
            <h2 class="text-center py-5">出品中の商品</h2>

            <!-- 出品ページへのリンク -->
            <div class="text-end my-4">
                <a href="{{ asset('/fleamarket/exhibit/new') }}" class="bg-lightgray p-3 link-dark text-decoration-none">商品を出品</a>
            </div>

            <!-- 商品一覧 -->
            <div class="text-center my-4 py-5">

                <p>{{ $msg }}</p>
                @if ($exhibited_items->isNotEmpty())
                @foreach ($exhibited_items as $exhibited_item)

                <div class="w-75 row m-0 mx-auto my-4" style="box-shadow: rgba(67, 71, 85, 0.27) 0px 0px 0.25em, rgba(90, 125, 188, 0.05) 0px 0.25em 1em;">
                    <img src="{{ asset($exhibited_item->item_photo->first()->path) }}" alt="" class="col w-25 p-0">
                    <div class="col-sm">
                        <div class="mx-3 my-5 text-start">
                            <a href="{{ asset('/fleamarket/item/'. $exhibited_item->id) }}" class="link-dark text-decoration-none h4">{{ $exhibited_item->item_info->name }}</a>
                        </div>
                        <p class="m-3 text-start">￥{{ number_format($exhibited_item->item_info->price) }}</p>
                    </div>
                    <div class="col my-3 d-flex align-items-center justify-content-center">
                        <div class="">
                            <div class="">
                                <a href="{{ asset('/fleamarket/item/edit/'. $exhibited_item->id) }}" class="border border-secondary text-decoration-none py-2 px-3 secondary-link-bg">編集</a>
                            </div>
                            <button name="delete" value="{{ $exhibited_item->id }}" class="delete btn btn-danger px-3 mt-4 rounded-0">削除</button>
                        </div>
                    </div>
                </div>

                @endforeach

            </div>
            @else

            <!-- 出品中の商品が無い場合 -->
            <div class="d-flex align-items-center justify-content-center" style="height: 250px;">
                <p class="text-center text-secondary">出品中の商品はありません。</p>
            </div>
            @endif

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


    {{-- <h1>出品中の商品</h1>
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
    @endif --}}
    <script>
        $(function() {
            $(".delete").click(function() {
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

    @include('footer')

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
</body>
</html>