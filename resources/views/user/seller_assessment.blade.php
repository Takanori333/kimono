<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('/css/star.css') }}">
    <title>Document</title>
</head>
<body>
    {{-- ユーザー情報 --}}
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
            </div>
        @endforeach
    @else
        <p>このユーザーは評価されていません</p>
    @endif
</body>
</html>