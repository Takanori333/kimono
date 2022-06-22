<nav id="header" class="p-3 fixed-top">
    <div class="p-3 fixed-top d-flex border-bottom flex-wrap w-100 js-header">
        <!-- サイト名 -->
        <h5 class="me-auto my-0 mr-mb-auto font-weight-normal p-2">
            <a href="{{ asset('/') }}" class="text-decoration-none js-header">和服フリマ（仮）</a>
        </h5>
        <ul class="nav">
            <!-- ゲスト・ユーザー共通部 -->
            <li class="nav-item"><a href="{{ asset('/fleamarket') }}" class="nav-link p-2 js-header header-link">フリマ</a></li>
            <li class="nav-item"><a href="{{ asset('/stylist') }}" class="nav-link p-2 js-header header-link">着付け師</a></li>
            <!-- ユーザー用 -->
            @if ( session("user") )
                <li class="nav-item"><a href="{{ asset('/user/info/{id}') }}" class="nav-link p-2 js-header header-link">マイページ</a></li>
                <li class="nav-item"><a href="" class="nav-link p-2 js-header header-link">ログアウト</a></li>
            @else
                @if ( session("stylist") )
                    <!-- スタイリスト用 -->
                    <li class="nav-item"><a href="{{ asset('/stylist_user/chat') }}" class="nav-link p-2 js-header header-link">チャット</a></li>
                    <li class="nav-item"><a href="{{ asset('/stylist_user/reserve') }}" class="nav-link p-2 js-header header-link">予約状況</a></li>
                    <li class="nav-item"><a href="{{ asset('/stylist_user/info') }}" class="nav-link p-2 js-header header-link">登録情報</a></li>
                    <li class="nav-item"><a href="" class="nav-link p-2 js-header header-link">ログアウト</a></li>
                @else
                    @if ( session("manager") )
                        <!-- 管理者用 -->
                        <li class="nav-item"><a href="{{ asset('/manager/user') }}" class="nav-link p-2 js-header header-link">ユーザー</a></li>
                        <li class="nav-item"><a href="{{ asset('/manager/item') }}" class="nav-link p-2 js-header header-link">商品</a></li>
                        <li class="nav-item"><a href="{{ asset('/manager/stylist') }}" class="nav-link p-2 js-header header-link">スタイリスト</a></li>
                        <li class="nav-item"><a href="{{ asset('/manager/faq') }}" class="nav-link p-2 js-header header-link">FAQ</a></li>
                        <li class="nav-item"><a href="" class="nav-link p-2 js-header header-link">ログアウト</a></li>
                    @else
                        <!-- ゲスト用 -->
                        <li class="nav-item"><a href="{{ asset('/user/signin') }}" class="nav-link p-2 js-header header-link">ログイン</a></li>
                        <li class="nav-item"><a href="{{ asset('/user/signup') }}" class="nav-link p-2 js-header header-link">新規登録</a></li>
                    @endif
                @endif
            @endif
        </ul>
    </div>
    @if (\Route::is('fleamarket.*'))
    <!-- フリマ用ヘッダー -->
    <div class="fixed-top d-flex border-bottom flex-wrap w-100 frima-header js-header">
        <!-- 検索窓 -->
        <div class="input-group m-3 p-1 w-50 mx-auto">
            <input type="text" class="form-control" placeholder="検索する">
            <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                <i class="bi bi-search"></i>
            </button>
        </div>

        <!-- 出品ページリンク -->
        <div class="me-4 py-2 px-3 d-flex align-items-center">
            <a href="" class="link-light text-decoration-none py-2 px-3 bg-secondary-link">出品</a>
        </div>
    </div>
    @endif
</nav>