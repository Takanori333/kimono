<!DOCTYPE html>
<html lang="ja">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>晴 re 着 - 着付け依頼履歴</title>
    <link rel="icon" type="image/x-icon" href="{{asset('/image/tagicon.png')}}">    
    <!-- フォント読み込み -->
    <link href="https://fonts.googleapis.com/css2?family=Kaisei+Opti&family=Shippori+Mincho&display=swap" rel="stylesheet">
    <!-- CDN読み込み -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>

<body>

    @include('header')

    <div class="container">
        <div class="contents pt-5 mt-5 w-75 mx-auto text-center">
            <h2 class="text-center py-5">着付け依頼履歴</h2>

            <p>{{ $msg }}</p>

            @if ($order_histories->isNotEmpty())

            <!-- 着付け依頼履歴一覧 -->
            <div class="text-center my-4 py-5">

                @foreach ($order_histories as $order_history)

                <div class="w-75 row m-0 mx-auto bg-lightoff my-4">
                    <div class="col-sm-4">
                        <div class="m-3 text-start">
                            <a href="{{ asset('/stylist/show/' . $order_history->stylist_id) }}" class="link-dark text-decoration-none h4">{{ $order_history->stylist_info->name }}</a>
                        </div>
                        <p class="m-3 text-start">{{ $order_history->services }}</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="m-3 text-end">￥{{ number_format($order_history->price) }}</p>
                        <p class="m-3 text-end">{{ str_replace('-', '/', $order_history->start_time) }}</p>
                        {{-- ユーザーがまだ評価していないとき --}}
                        @if (!$order_history->stylist_comment)
                        {{-- 現在時刻がサービスの終了時間よりも後の時 --}}
                        @if (now() >= $order_history->end_time)
                        {{-- 評価項目の表示 --}}
                        <form action="{{ asset('/user/assess_stylist') }}" class="mb-3 me-3">
                            <div class="text-start mb-1">
                                <label class="">評価</label>
                                <select name="point" id="" class="">
                                    @for ($i=1;$i<=5;++$i) <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                </select>
                            </div>
                            <div class="row mx-auto">
                                <input type="text" name="comment" class="form-control col me-2">
                                <div class="col-sm-3">
                                    <input type="submit" value="評価する" class="btn btn-secondary">
                                </div>
                            </div>
                            <input type="hidden" value="{{ $order_history->toJson() }}" name="order_history">
                        </form>
                        @endif
                        @endif
                    </div>
                    <div class="col-sm-2">
                        <a class="m-3 link-secondary" href="{{ asset('/user/order_detail/'.$order_history->id) }}" style="width:auto;height:auto" target="_blank"><p class="m-0 p-0">詳細</p></a> 
                    </div>
                </div>

                @endforeach

            </div>

            @else

            <!-- 着付け依頼歴が無い場合 -->
            <div class="d-flex align-items-center justify-content-center" style="height: 250px;">
                <p class="text-center text-secondary">着付け依頼をしていません。</p>
            </div>

            @endif

            {{-- <!-- ページネーション -->
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
            </nav> --}}

        </div>
    </div>

    <span class="d-block" style="height: 100px;"></span>

    @include('footer')

    {{--
    <h1>着付け依頼履歴</h1>
    <p>{{ $msg }}</p>
    @if ($order_histories->isNotEmpty())
    @foreach ($order_histories as $order_history)
    <div>
        <a href="{{ asset('/stylist/show/' . $order_history->stylist_id) }}">{{ $order_history->stylist_info->name }}</a>
        <p>{{ $order_history->services }}</p>
        <p>{{ str_replace('-', '/', $order_history->created_at) }}</p>
        <p>{{ number_format($order_history->price) }}円</p> --}}
        {{-- ユーザーがまだ評価していないとき --}}{{--
        @if (!$order_history->stylist_comment) --}}
        {{-- 現在時刻がサービスの終了時間よりも後の時 --}} {{--
        @if (now() >= $order_history->end_time) --}}
        {{-- 評価項目の表示 --}} {{--
        <form action="{{ asset('/user/assess_stylist') }}">
            評価
            <select name="point" id="">
                @for ($i=1;$i<=5;$i++) <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
            </select>
            <br>
            <input type="text" name="comment">
            <input type="submit" value="評価する">
            <input type="hidden" value="{{ $order_history->toJson() }}" name="order_history">
        </form>
        @endif
        @endif
    </div>
    @endforeach
    @else
    <p>着付けを依頼していません</p>
    @endif
    --}}

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>