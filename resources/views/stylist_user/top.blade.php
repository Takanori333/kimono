<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{ asset('/js/jquery.js') }}"></script>
    <title>Document</title>
</head>
<body>
    @php
        $stylist = unserialize(session()->get("stylist"));        
    @endphp
    <div>
        <div>
            <img src="{{ asset($stylist->getIcon()) }}" width="200px" height="300px">
            <h3>{{ $stylist->getName() }}</h3>
            <a href="{{ '/stylist_user/info ' }}">編集</a>
            <br>
            <a href="{{ '/stylist_user/signout ' }}">サインアウト</a>            
        </div>
        <br>
        <div>
            <a href="{{ asset('/stylist_user/reserve') }}">予約一覧</a>
            @foreach ($reserve_list as $reserve)
                <a href="{{ asset('/stylist_user/reserve_detail/'.$reserve->id) }}">
                    <div>{{ $reserve->address }} {{ $reserve->start_time }}から{{ $reserve->end_time }}まで</div>
                </a>
            @endforeach
        </div>
        <div>
            予約可能時間
            <br>
            @foreach ($freetime as $time)
                <div>
                    {{ $time->start_time }}から{{ $time->end_time }}まで
                    <a href="javascript:void(0);" onclick="delete_time('{{ asset('/stylist_user/delete_freetime_DB/') }}','{{ csrf_token() }}','{{ $time->id }}')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-plus" viewBox="0 0 16 16">
                            <path d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z"/>
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                        </svg>
                    </a>    
                </div>
            @endforeach            
                <input type="datetime-local" name="start_time" id="start_time">から<input type="datetime-local" name="end_time" id="end_time">まで
                <a href="javascript:void(0);" onclick="add_new_time('{{ asset('/stylist_user/freetime_DB') }}','{{ csrf_token() }}')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-plus" viewBox="0 0 16 16">
                        <path d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z"/>
                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                    </svg>
                </a>
            </form>
        </div>
        <div>            
            予約可能<input type="checkbox" onchange="change_status('{{ asset('/stylist_user/change_status') }}','{{ csrf_token() }}',this)" 
            @if ($status=='1')
                checked
            @endif
            >
        </div>
    </div>
    <script src="{{ asset('/js/stylist_top.js') }}"></script>
</body>
</html>