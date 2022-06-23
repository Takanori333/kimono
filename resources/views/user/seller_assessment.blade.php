<!DOCTYPE html>
<html lang="ja">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>和服フリマ（仮）- 販売者評価</title>
    <!-- フォント読み込み -->
    <link href="https://fonts.googleapis.com/css2?family=Kaisei+Opti&family=Shippori+Mincho&display=swap" rel="stylesheet">
    <!-- CDN読み込み -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('/css/star.css') }}">
</head>

<body>

    @include('header')

    <div class="container">
        <div class="contents pt-5 mt-5 w-75 mx-auto">
            <!-- <div class="fixed-top d-block"> -->
            <div class="row my-4">
                <div class="col-2 p-0 d-flex align-items-center">
                    <!-- アイコン -->
                    <img src="{{ asset($page_user->user_info->icon) }}" alt="" class="w-100 img-fluid">
                </div>
                <!-- ユーザ名 -->
                <div class="col d-flex align-items-center fs-3">
                    <a href="{{ asset('/user/show/' . $page_user->id) }}" class="link-dark text-decoration-none">{{ $page_user->user_info->name }}</a>
                </div>
            </div>
            <!-- 評価 -->
            <div class="my-4">
                <p class="d-inline me-3">販売者評価</p>
                <div class="Stars" style="--rating: {{ round($page_user->seller_assessment->avg('point'), 1) }};" aria-label="Rating of this product is 3.5 out of 5.">
                    @if (round($page_user->seller_assessment->avg("point"), 1) == 0)
                    <p class="d-inline">-</p>
                    @else
                    <p class="d-inline">{{ round($page_user->seller_assessment->avg("point"), 1) }}</p>
                    @endif
                </div>
            </div>
            <!-- </div> -->

            <p class="fs-5 ms-3">評価一覧</p>


            <div class="">

                @if ($assessment_users->isNotEmpty())
                @foreach ($assessment_users as $assessment_user)

                <div class="row my-3">
                    <div class="col-1 p-0">
                        <a href="{{ asset('/user/show/' . $assessment_user->user_id) }}">
                            <!-- アイコン -->
                            <img src="{{ asset($assessment_user->icon) }}" alt="" class="w-100">
                        </a>
                    </div>
                    <div class="col-10">
                        <!-- ユーザ名 -->
                        <div class="row">
                            <div class="col">
                                <a href="{{ asset('/user/show/' . $assessment_user->user_id) }}" class="link-dark text-decoration-none my-1 d-block">{{ $assessment_user->name }}</a>
                            </div>
                            <div class="col Stars mt-2 text-end" style="--rating: {{ $assessment_user->point }};" aria-label="Rating of this product is {{ $assessment_user->point }} out of 5.">
                                <p class="d-inline">{{ $assessment_user->point }}</p>
                            </div>
                        </div>
                        <div class="bg-lightoff m-2 rounded p-2">
                            <!-- コメント本文 -->
                            <p class="text-break mb-0">{{ $assessment_user->text }}</p>
                            <p class="text-secondary mb-0 small">{{ str_replace('-', '/', $assessment_user->assessment_date) }}</p>
                        </div>
                    </div>
                </div>

                @endforeach
                @else

                <p class="text-secondary" style="height: 250px;">このユーザーは評価されていません</p>

                @endif

                <span class="d-block" style="height: 100px;"></span>

            </div>
        </div>
    </div>
    </div>

    @include('footer')

    <!-- {{-- ユーザー情報 --}}
    <img src="{{ asset($page_user->user_info->icon) }}" alt="">
    <br>
    <a href="{{ asset('/user/show/' . $page_user->id) }}">{{ $page_user->user_info->name }}</a>
    <br>
    評価{{ round($page_user->seller_assessment->avg("point"), 1) }}</a>
    <div class="Stars" id="star" style="--rating: {{ round($page_user->seller_assessment->avg("point"), 1) }};"></div>
    <h2>評価一覧</h2>
    {{-- 評価詳細 --}}
    @if ($assessment_users->isNotEmpty())
    @foreach ($assessment_users as $assessment_user)
    <div>
        <img src="{{ asset($assessment_user->icon) }}" alt="">
        <a href="{{ asset('/user/show/' . $assessment_user->user_id) }}">{{ $assessment_user->name }}</a>
        <span>{{ $assessment_user->point }}</span>
        <div class="Stars" id="star" style="--rating: {{ $assessment_user->point }};"></div>
        <p>{{ $assessment_user->text }}</p>
        <span>評価日時：{{ str_replace('-', '/', $assessment_user->assessment_date) }}</span>
    </div>
    @endforeach
    @else
    <p>このユーザーは評価されていません</p>
    @endif -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>