<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>晴 re 着 - スタイリストトップ</title>
    <link rel="icon" type="image/x-icon" href="{{asset('/image/tagicon.png')}}">    
    <link href="{{ asset('css/bootcss/css/bootstrap.min.css') }}" rel="stylesheet"  crossorigin="anonymous">
    <script src="{{ asset('js/bootjs/js/bootstrap.bundle.min.js') }}"  crossorigin="anonymous"></script>
    <script src="{{ asset('/js/jquery.js') }}"></script>
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/my-sheet.css') }}">
</head>
<body>
    @include('stylist_user.header')
    @php
        use Illuminate\Support\Carbon;
        $stylist = unserialize(session()->get("stylist"));        
    @endphp
    <div class="container pt-5 mt-5">
        <div class="row">
            <div class="col-12 col-xxl-1   col-xl-1">
            </div>
            <div class="col-12 col-xxl-4   col-xl-4">
                <div class="container">
                    <div class="col" style="text-align: -webkit-center;">
                        <div class="card" style="width: 18rem;">
                            <img src="{{ asset($stylist->getIcon()) }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <p class="card-text"><h3>{{ $stylist->getName() }}</h3></p>
                                <p class="card-text"><h6>フォロワー人数:{{ $follower_count }}</h6></p>
                                <div class="card-text text-end">
                                    <a href="{{ '/stylist_user/info ' }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                        </svg></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col text-center">
                        <a class="link-secondary" href="{{ '/stylist_user/signout ' }}">ログアウト</a>
                    </div>
                    <br>
                </div>
            </div>
            <div class="col-12 col-xxl-2   col-xl-2">
            </div>
            <div class="col-12 col-xxl-4   col-xl-4">
                <div  class="container" style="width:400px">
                    <div class="row" style="justify-content: center">
                        <div class="card" style="min-width: 18rem;">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="row">
                                        <h5 class="col-11 text-center">直近の予約</h5>
                                        <a class="col-1" href="{{ asset('/stylist_user/reserve') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </li>
                                @if ($reserve_list->isEmpty())
                                <li class="list-group-item text-center">
                                    <div>直近の予約はありません</div>
                                </li>
                                @endif
                                @foreach ($reserve_list as $reserve)
                                <li class="list-group-item text-center">
                                    <a href="{{ asset('/stylist_user/reserve_detail/'.$reserve->id) }}" class="dropdown-item" style="padding: 0px">
                                        <div>{{Carbon::parse($reserve->start_time)->format('m月d日 H時i分')}}~{{Carbon::parse($reserve->end_time)->format('m月d日 H時i分')}}</div>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <br>
                    <div class="row" style="justify-content: center">
                        <div class="card" style="max-height: 200px;overflow-y: auto;">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><h5 class="text-center">予約可能時間</h5></li>
                                <li class="list-group-item">
                                    <div class="row">
                                        <input type="datetime-local" class="col-5 form-control-sm" name="start_time" id="start_time">
                                        <h6 class="col-1 text-center">-</h6>
                                        <input type="datetime-local" class="col-5 form-control-sm" name="end_time" id="end_time">
                                        <a class="col-1" href="javascript:void(0);" onclick="add_new_time('{{ asset('/stylist_user/freetime_DB') }}','{{ csrf_token() }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-plus" viewBox="0 0 16 16">
                                                <path d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z"/>
                                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </li>
                                @if ($freetime->isEmpty())
                                <li class="list-group-item">
                                    <div class="row text-center">
                                       <div> 活動場所可能時間はありません</div>
                                    </div>
                                </li>
                                @endif
                                @foreach ($freetime as $time)

                                <li class="list-group-item">
                                    <div class="row text-center">
                                        <div class="col-11">{{Carbon::parse($time->start_time)->format('m月d日 H時i分')}}~{{Carbon::parse($time->end_time)->format('m月d日 H時i分')}}</div>
                                        <a class="col-1 link-danger" href="javascript:void(0);" onclick="delete_time('{{ asset('/stylist_user/delete_freetime_DB/') }}','{{ csrf_token() }}','{{ $time->id }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-x" viewBox="0 0 16 16">
                                                <path d="M6.146 7.146a.5.5 0 0 1 .708 0L8 8.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 9l1.147 1.146a.5.5 0 0 1-.708.708L8 9.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 9 6.146 7.854a.5.5 0 0 1 0-.708z"/>
                                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                            </svg></a>
                                    </div>
                                </li>

                                {{-- <div>
                                    
                                    <a href="javascript:void(0);" onclick="delete_time('{{ asset('/stylist_user/delete_freetime_DB/') }}','{{ csrf_token() }}','{{ $time->id }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-plus" viewBox="0 0 16 16">
                                            <path d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z"/>
                                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                        </svg>
                                    </a>    
                                </div> --}}
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-check form-switch" style="display: flex;justify-content: center;">
                            <input  class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" onchange="change_status('{{ asset('/stylist_user/change_status') }}','{{ csrf_token() }}',this)"
                                @if ($status=='1')
                                    checked
                                @endif
                            >
                            <label class="form-check-label" for="flexSwitchCheckDefault">予約可能</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('stylist_user.footer')
    <script src="{{ asset('/js/stylist_top.js') }}"></script>
</body>
</html>