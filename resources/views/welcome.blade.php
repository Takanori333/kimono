<!doctype html>
<html lang="ja">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>和服フリマ（仮）</title>
    <!-- フォント読み込み -->
    <link href="https://fonts.googleapis.com/css2?family=Kaisei+Opti&family=Shippori+Mincho&display=swap" rel="stylesheet">
    <!-- CDN読み込み -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>

<body>

    @include('header')

    <!-- トップ画像 -->
    <div class="container-fluid js-mainVisual">
        <div class="row">
            <div class="col-xs-12 cover-img" style="background-image:url('{{ asset('image/top_img.jpg') }}');">
                <div class="cover-text text-center">
                    <p class="text-light fs-1" style="font-family: 'Kaisei Opti', serif;">和服フリマ（仮）</p>
                    <small class="text-light">Wafuku Flea Market and Dressing</small>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="container" style="height: 1000px;"> -->
    <!-- <div class="contents pt-5 mx-auto"> -->
    <div class="text-center my-5" style="height: 400px;">
        <p class="fs-5 pt-5">はじめに</p>
        <br>
        <p class="">
            良い感じのおしゃれで雅な説明をしています。<br><br>
            和服フリマ（仮）はこんなことします。<br><br>
            気軽に着物をシェアしようぜ的な、、、。<br><br>
            みんな使ってね。;)
        </p>
    </div>

    <div class="mb-5">

        <!-- フリマリンク -->
        <div class="FleM">
            <div class="fleM row">
                <div class="col mt-5 ms-5 d-flex justify-content-center align-items-end">
                    <div class="m-4">
                        <a href="{{ asset('/fleamarket') }}" class="fs-5 link-dark text-decoration-none border-bottom d-block">フリマ</a>
                        <p class="mt-4">商品を購入。</p>
                        <p>もう着ない和服を出品できる。</p>
                        <p>など説明をする。</p>
                        <a href="{{ asset('/fleamarket') }}" class="btnarrow4 link-dark">商品を見る</a>
                    </div>
                </div>
                <div class="col"></div>
                <img src="{{ asset('image/clo.jpg') }}" alt="">
            </div>
        </div>

        <!-- 着付けリンク -->
        <div class="Dressing">
            <div class="dressing-link row">
                <div class="col"></div>
                <div class="col mt-5 d-flex justify-content-center align-items-end">
                    <div class="m-4">
                        <a href="{{ asset('/stylist') }}" class="fs-5 link-dark text-decoration-none border-bottom d-block">着付け</a>
                        <p class="mt-4">スタイリストを選んで依頼。</p>
                        <p>着付けを依頼する。</p>
                        <p>着付け依頼を請ける。</p>
                        <p>とか説明をする。</p>
                        <a href="{{ asset('/stylist') }}" class="btnarrow4 link-dark">着付け師を見る</a>
                    </div>
                </div>
                <img src="{{ asset('image/kitsuke.jpg') }}" alt="">
            </div>
        </div>
    </div>
    <!-- </div> -->
    <!-- </div> -->

    @include('footer')

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>