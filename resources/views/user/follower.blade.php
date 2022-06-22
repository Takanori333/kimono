<!DOCTYPE html>
<html lang="ja">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>和服フリマ（仮）- フォロワー</title>
    <!-- フォント読み込み -->
    <link href="https://fonts.googleapis.com/css2?family=Kaisei+Opti&family=Shippori+Mincho&display=swap" rel="stylesheet">
    <!-- CDN読み込み -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>

    @include('header')

    <div class="container">
        <div class="contents pt-5 mt-5 w-75 mx-auto text-center">
            <h2 class="text-center py-5">フォロワー</h2>

            @if ($followers_of_page_user->isNotEmpty())

            <!-- フォロワー一覧 -->
            <div class="text-center my-4 py-5">

                @foreach ($followers_of_page_user as $follower_of_page_user)

                <div class="row my-4">
                    <div class="col-1 p-0 d-flex align-items-center">
                        <a href="{{ asset('/user/show/' . $follower_of_page_user->user_id) }}" class="">
                            <img src="{{ asset($follower_of_page_user->icon) }}" alt="" class="w-100 img-fluid">
                        </a>
                    </div>
                    <div class="col d-flex align-items-center">
                        <a href="{{ asset('/user/show/' . $follower_of_page_user->user_id) }}" class="text-decoration-none link-dark">{{ $follower_of_page_user->name }}</a>
                    </div>
                    <div class="col d-flex align-items-center justify-content-end">
                        {{-- ログイン状態であるかを確認 --}}
                        @if ($user)
                            {{-- アクセスしたユーザーがフォローしているかを確認 --}}
                            @if (in_array($follower_of_page_user->id, $follows_of_access_user))
                            {{-- フォローしているときは解除ボタンの表示 --}}
                            <button value="{{ $follower_of_page_user->user_id }}" id="{{ $follower_of_page_user->user_id }}" class="btn btn-outline-secondary" name="unfollow">解除</button>
                            @elseif ($user->id == $follower_of_page_user->user_id)
                            {{-- ユーザーがアクセスしたユーザー自身の時は何も表示しない --}}
                            @else
                            {{-- フォローしていないときはフォローボタンの表示 --}}
                            <button value="{{ $follower_of_page_user->user_id }}" id="{{ $follower_of_page_user->user_id }}" class="btn btn-secondary" name="follow">フォローする</button>
                            @endif
                        @else
                            {{-- ログインしていないときは何も表示しない --}}
                        @endif
                    </div>
                </div>

                @endforeach

            </div>

            @else

            <!-- フォロワーがいない場合 -->
            <div class="d-flex align-items-center justify-content-center" style="height: 500px;">
                <p class="text-secondary" style="margin-bottom: 100px;">フォロワーがいません。</p>
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

            <span class="d-block" style="height: 100px;"></span>

        </div>
    </div>

    <script>
        $(function() {
            $("button").click(function() {
                let name = $(this).attr("name");
                let follow_id = $(this).val();
                // フォローするボタンが押されたとき
                if (name == "follow") {
                    $.ajax({
                        type: "get",
                        url: "/user/follow_DB",
                        data: {
                            "follow_id": follow_id
                        },
                        dataType: "json"
                    }).done(function(data) {
                        // ボタンを解除するボタンに変更
                        $("#" + data.follow_id).attr("name", "unfollow");
                        $("#" + data.follow_id).attr("class", "btn btn-outline-secondary");
                        $("#" + data.follow_id).text("解除");
                    }).fail(function(XMLHttpRequest, textStatus, error) {
                        console.log(error);
                    })
                // 解除するボタンが押されたとき
                } else if (name="unfollow"){
                    $.ajax({
                        type: "get",
                        url: "/user/unfollow_DB",
                        data: {
                            "follow_id": follow_id
                        },
                        dataType: "json"
                    }).done(function(data) {
                        // ボタンをフォローするボタンに変更
                        $("#" + data.follow_id).attr("name", "follow");
                        $("#" + data.follow_id).attr("class", "btn btn-secondary");
                        $("#" + data.follow_id).text("フォローする");
                    }).fail(function(XMLHttpRequest, textStatus, error) {
                        console.log(error);
                    })
                }
            })
        })
    </script>

    @include('footer')

    <!-- <h1>フォロワー</h1>
    @if ($followers_of_page_user->isNotEmpty())
    {{-- フォロワーがいたとき --}}
    @foreach ($followers_of_page_user as $follower_of_page_user)
    <div>
        <img src="{{ asset($follower_of_page_user->icon) }}" alt="">
        <br>
        <a href="{{ asset('/user/show/' . $follower_of_page_user->user_id) }}">{{ $follower_of_page_user->name }}</a>
        {{-- アクセスしたユーザーがフォローしているかを確認 --}}
        @if (in_array($follower_of_page_user->id, $follows_of_access_user))
        {{-- フォローしているときは解除ボタンの表示 --}}
        <button value="{{ $follower_of_page_user->user_id }}" id="{{ $follower_of_page_user->user_id }}" class="unfollow">解除</button>
        {{-- @elseif ($user->id == $follower_of_page_user->user_id) --}}
        {{-- ユーザーがアクセスしたユーザー自身の時は何も表示しない --}}
        @else
        {{-- フォローしていないときはフォローボタンの表示 --}}
        <button value="{{ $follower_of_page_user->user_id }}" id="{{ $follower_of_page_user->user_id }}" class="follow">フォローする</button>
        @endif
    </div>
    @endforeach
    @else
    {{-- フォロワーがいないとき --}}
    <p>フォロワーはいません</p>
    @endif -->

    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>