<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <h1>フォロワー</h1>
    @if ($followers_of_page_user->isNotEmpty())
        {{-- フォロワーがいたとき --}}
        @foreach ($followers_of_page_user as $follower_of_page_user)
            <div>
                <img src="{{ asset($follower_of_page_user->user_info->icon) }}" alt="">
                <br>
                <a href="{{ asset('/user/show/' . $follower_of_page_user->user_info->id) }}">{{ $follower_of_page_user->user_info->name }}</a>
                {{-- アクセスしたユーザーがフォローしているかを確認 --}}
                @if ($followers_of_access_user->contains($follower_of_page_user))
                    {{-- フォローしているときは解除ボタンの表示 --}}
                    <button value="{{ $follower_of_page_user->user_info->id }}" id="{{ $follower_of_page_user->user_info->id }}" class="unfollow" >解除</button>
                @elseif ($user->id == $follower_of_page_user->user_info->id)
                    {{-- ユーザーがアクセスしたユーザー自身の時は何も表示しない --}}
                @else
                    {{-- フォローしていないときはフォローボタンの表示 --}}
                    <button value="{{ $follower_of_page_user->user_info->id }}" id="{{ $follower_of_page_user->user_info->id }}" class="follow">フォローする</button>
                @endif
            </div>
        @endforeach
    @else
        {{-- フォロワーがいないとき --}}
        <p>フォロワーはいません</p>
    @endif
    <script>
        $(function(){
            $(".follow").click(function(){
                let follow_id = $(this).val(); 
                $.ajax({
                    type: "get",
                    url: "/user/follow_DB",
                    data: {"follow_id": follow_id},
                    dataType: "json"
                }).done(function(data){
                    // alert(data.follow_id);
                    $("#" + data.follow_id).removeClass('follow');
                    $("#" + data.follow_id).addClass('unfollow');
                    $("#" + data.follow_id).text("解除")
                }).fail(function(XMLHttpRequest, textStatus, error){
                    console.log(error);
                })
            })
        });

        $(function(){
            $(".unfollow").click(function(){
                let follow_id = $(this).val(); 
                $.ajax({
                    type: "get",
                    url: "/user/unfollow_DB",
                    data: {"follow_id": follow_id},
                    dataType: "json"
                }).done(function(data){
                    // alert(data.follow_id);
                    $("#" + data.follow_id).removeClass('unfollow');
                    $("#" + data.follow_id).addClass('follow');
                    $("#" + data.follow_id).text("フォローする")
                }).fail(function(XMLHttpRequest, textStatus, error){
                    console.log(error);
                })
            })
        })
    </script>
</body>
</html>