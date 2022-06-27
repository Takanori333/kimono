<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>晴 re 着 - 活動一覧</title>
    <link rel="icon" type="image/x-icon" href="{{asset('/image/tagicon.png')}}">    

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
    <div class="container pt-5 mt-5">
        <table class="table table-striped table-hover mt-5">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">開始時間</th>
                    <th scope="col">終了時間</th>
                    <th scope="col">場所</th>
                    <th scope="col">料金</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reserve_list as $i=>$reserve)
                <tr
                    @if (strtotime($reserve->end_time)<time())
                        class="table-danger"
                    @endif
                >
                    <th scope="row">{{ $i }}</th>
                    <td>{{Carbon::parse($reserve->start_time)->format('Y年m月d日 H時i分')}}</td>
                    <td>{{Carbon::parse($reserve->end_time)->format('Y年m月d日 H時i分')}}</td>
                    <td>{{ $reserve->address }}</td>
                    <td>{{ $reserve->price }}</td>
                    <td><a href="{{ asset('/stylist_user/reserve_detail/'.$reserve->id) }}" target="_blank">詳細</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @include('footer')
</body>
</html>