<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>スタイリスト一覧</title>
    <!-- フォント読み込み -->
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/my-sheet.css') }}">
    <!-- CDN読み込み -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"></head>
    {{-- 星マーク --}}
    <link rel="stylesheet" href="{{ asset('/css/star.css') }}">
    <title>Document</title>
</head>
<body>
    @include('header')
    @php
        use Illuminate\Support\Carbon;
        
    @endphp
    <div class="container mt-5 pt-5">
        <div class="contents p-5 w-75 mx-auto text-center">
            <div class="row text-end justify-content-end">
                @if (!session('stylist')&&!session('manager'))
                    <a class="link-secondary" href="{{ asset('/user/stylist_chat/'.$stylist->id) }}" style="width: auto" target="_blank">チャット</a>                
                @endif            
            </div>
            <div class="row my-4">
                <div class="col-12 col-xl-4 col-xxl-4 d-grid gap-2">
                    <div class="row">
                        <img src="{{ asset($stylist->icon) }}" alt="" height="300px" width="250px">
                    </div>
                    <div class="row text-center">
                        <div>フォロワー人数: {{ $follower_count }}</div>
                    </div>
                    @if ($is_follow!=2)
                        @if ($is_follow==1)
                        <form action="{{ asset('/stylist/unfollow') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $stylist->id }}">
                            <button type="submit" class="btn btn-outline-danger" >フォロー解除</button>
                        </form>
                        @else
                        <form action="{{ asset('/stylist/follow') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $stylist->id }}">
                            <button type="submit" class="btn btn-outline-secondary" >フォローする</button>                            
                        </form>
                        @endif
                    @endif
                </div>
                <div class="col-12 col-xl-8 col-xxl-8 ">
                    <div class="container ml-2 d-grid gap-3 fs-4">
                        <div class="row border-bottom">
                            <div class="col text-start">
                                名前:
                            </div>
                            <div class="col text-start">
                                {{ $stylist->name }}
                            </div>
                        </div>
                        <div class="row border-bottom">
                            <div class="col text-start">
                                地域:
                            </div>
                            <div class="col text-start">
                                {{ $areas }}
                            </div>
                        </div>
                        <div class="row border-bottom">
                            <div class="col text-start">
                                料金
                            </div>
                            <div class="col text-start">
                                ￥{{ $stylist->min_price }}~{{ $stylist->min_price }}
                            </div>
                        </div>
                        <div class="row border-bottom">
                            <div class="col text-start">
                                評価:
                            </div>
                            <div class="col text-start">
                              @if ($stylist->point)
                                <div class="col Stars card-text mb-1 fs-2" style='--rating: {{$stylist->point}};' aria-label='Rating of this product is {{$stylist->point}} out of 5.'></div>
                              @else
                                <p class="card-text mb-1 text-end">-</p>                        
                              @endif
                            </div>
                        </div>
                        <div class="row border-bottom">
                            <div class="col text-start">
                                サービス:
                            </div>
                            <div class="col text-start">
                                {{ $services }}
                            </div>
                        </div>
                        <div class="row border-bottom">
                            <div class="col text-start">
                                     活動可能時間:
                                <div class="row overflow-auto" style="max-height: 60px;">
                                    @if ($freetime->isEmpty())
                                         活動可能時間はありません
                                    @endif
                                    @foreach ($freetime as $time)
                                    <div class="">
                                        <div class="row text-center h6">
                                            <div class="col-11">{{Carbon::parse($time->start_time)->format('m月d日 H時i分')}}~{{Carbon::parse($time->end_time)->format('m月d日 H時i分')}}</div>
                                        </div>
                                    </div>
                                    @endforeach                            
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
            <div class="row justify-content-center">
                <div class="row h1 justify-content-center">レビュー</div>
                <div class="row border overflow-auto justify-content-center align-items-center h2" style="height: 200px">
                    @if ($comments->isEmpty())
                        レビューはありません
                    @else
                    @foreach ($comments as $comment)
                    <div class="row">
                        <div class="row h6 text-start">             
                            <div class="col  m-0 p-0">
                                <a class=" link-secondary  m-0 p-0" href="{{ asset("/user/show/".$comment->customer_id) }}" style="width:auto">{{ $comment->name }}</a> 
                            </div>
                            <div class="col flex-grow-1 Stars mb-1 fs-4 text-end" style='--rating: {{$comment->point}};' aria-label='Rating of this product is {{$comment->point}} out of 5.'></div>
                        </div>
                        <div class="row h5 rounded p-2 ml-1" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;">
                            {{ $comment->text }}
                        </div>
                    </div>
                    @endforeach                        
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('footer')
</body>
</html>