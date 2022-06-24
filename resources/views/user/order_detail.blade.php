<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>予約詳細</title>
    <link href="{{ asset('css/bootcss/css/bootstrap.min.css') }}" rel="stylesheet"  crossorigin="anonymous">
    <script src="{{ asset('js/bootjs/js/bootstrap.bundle.min.js') }}"  crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/my-sheet.css') }}">
</head>
<body>
    @include('header')
    @php
        use Illuminate\Support\Carbon;
    @endphp
    <div class="pt-5 mt-5"></div>
    <div class="container p-5 mt-5 border secondary" style="padding: 50px;max-width: 600px">
        <table class="table text-center">
            <tbody>
                <tr>
                    <td>顧客</td>
                    <td><a class="link-secondary" href="{{ asset('/stylist/show/'.$reserve->stylist_id) }}" target="_blank">{{ $reserve->name }} </a></td>
                </tr>
                <tr>
                    <td>人数</td>
                    <td>{{ $reserve->count }}人</td>
                </tr>
                <tr>
                    <td>場所</td>
                    <td>{{ $reserve->address }}</td>
                </tr>
                <tr>
                    <td>時間</td>
                    <td>{{Carbon::parse($reserve->start_time)->format('m月d日 H時i分')}}~{{Carbon::parse($reserve->end_time)->format('m月d日 H時i分')}}</td>
                </tr>
                <tr>
                    <td>サービス</td>
                    <td>{{ $reserve->services }}</td>
                </tr>
                <tr>
                    <td>料金</td>
                    <td>{{ $reserve->price }}円</td>
                </tr>

            </tbody>
        </table>
    </div>
    @include('footer')
</body>
</html>