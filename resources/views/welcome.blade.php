<!doctype html>
<html lang="ja">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="{{asset('/image/tagicon.png')}}">
    <title>晴 re 着 </title>
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
                    <p class="text-light fs-1" style="font-family: 'Kaisei Opti', serif;">晴 re 着</p>
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
            手元の着物を捨てるのはもったいないけれど、譲る相手がいない。<br><br>
            着物を着てみたいけれど、着方が分からない。<br><br>
            晴re着はそんな悩みを持つ皆さんが着物を気軽に着るためのお手伝いをします。<br><br>
        </p>
    </div>

    <div class="mb-5">

        <!-- フリマリンク -->
        <div class="FleM">
            <div class="fleM row">
                <div class="col mt-5 ms-5 d-flex justify-content-center align-items-end">
                    <div class="m-4">
                        <a href="{{ asset('/fleamarket') }}" class="fs-5 link-dark text-decoration-none border-bottom d-block">フリマ</a>
                        <p class="mt-4">手元の着物を出品、出品された着物を購入することができます。</p>
                        <p>箪笥の肥やしになっている着物はありませんか？</p>
                        <p>欲しい人の手元に欲しい着物が届きます。</p>
                        <p></p>
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
                        <p class="mt-4">着付けの依頼をはじめ、着物を着た時の</p>
                        <p>メイク、ヘアメイクの依頼をすることができます。</p>
                        <p>要望に合った着付け師を探してみましょう。</p>
                        <p></p>
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