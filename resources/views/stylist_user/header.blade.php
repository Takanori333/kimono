@php
    use App\Functions\ChatFunction;
    $chat_f = new ChatFunction();
    $chat_count = $chat_f->stylist_user_listen_chat();
@endphp
<script src="{{ asset('js/header.js') }}"></script>
<nav id="header" class="p-3" style="margin-bottom: 100px">
        <div class="p-3 fixed-top d-flex border-bottom flex-wrap w-100 bg-white">
            <h5 class="me-auto my-0 mr-mb-auto font-weight-normal p-2"><a href="{{ asset('/') }}" class="link-dark text-decoration-none h4">和服フリマ（仮）</a></h5>
            <ul class="nav">
                <li class="nav-item">
                    <a href="{{  asset('/stylist_user') }}" class="nav-link p-2 text-dark js-header header-link">
                        マイページ
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{  asset('/stylist_user/chat') }}" class="nav-link p-2 text-dark js-header header-link" target="_blank">
                            チャット @if ($chat_count!=0)
                            <span class="badge bg-danger rounded-pill ">{{ $chat_count }}</span>
                            @endif
                    </a>
                </li>
            </ul>
        </div>
</nav>