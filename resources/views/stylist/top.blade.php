<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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
<body>
  @php
    $stylist = unserialize(session()->get("stylist"));
    $state_list = [
        "北海道","青森県","岩手県","宮城県","秋田県","山形県","福島県","茨城県","栃木県","群馬県","埼玉県","千葉県","東京都","神奈川県","新潟県","富山県","石川県","福井県","山梨県","長野県","岐阜県","静岡県","愛知県","三重県","滋賀県","京都府","大阪府","兵庫県","奈良県",
        "和歌山県","鳥取県","島根県","岡山県","広島県","山口県","徳島県","香川県","愛媛県","高知県","福岡県","佐賀県","長崎県","熊本県","大分県","宮崎県","鹿児島県","沖縄県"
    ];
    $service_list = [
        "着付け","メイク","ヘアアレンジ","講師"
    ]
  @endphp
  @include('header')
    <div class="container">
      <div class="contents pt-5 mt-5 w-100 mx-auto text-center">
        <form action="{{ asset("/stylist") }}" method="GET" id="bar_form">
          @csrf
          <div class="row">
            <div class="col-12 col-xl-3 col-xxl-3">
              <div class="input-group m-3 p-1 mx-auto">
                <input type="text" class="form-control" placeholder="検索する">
                <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                    <i class="bi bi-search"></i>
                </button>
              </div>            
            </div>
            <div class="col" style="align-self: center">
              <select name="area" id="" onchange="form_submit()">
                <option value="" selected>活動場所</option>
                @foreach ($state_list as $state)
                    <option value="{{ $state }}"
                      @if ($state == $area)
                          selected
                      @endif
                    >{{ $state }}</option>
                @endforeach
              </select>
            </div>

            <div class="col" style="align-self: center">
              <select name="service" id="" onchange="form_submit()">
                <option  value="" selected>サービスメニュー</option>
                @foreach ($service_list as $s)
                <option value="{{ $s }}" 
                  @if ($service==$s)
                    selected
                  @endif
                >{{ $s }}</option>
                @endforeach
              </select>
            </div>

            <div class="col" style="align-self: center">
              <select name="sort" id="" onchange="form_submit()">
                <option value="" selected>ソート順</option>                
                <option value="min_price" @if ($sort=="min_price")
                    selected
                @endif>料金順</option>
                <option value="point" @if ($sort=="point")
                    selected
                @endif>評価順</option>
              </select>
            </div>
          </div>
        </form>
        <div class="row">
        @foreach ($stylist_list as $stylist)
          <div class="col my-4 col-xl-4 col-xxl-4" style="text-align: -webkit-center;">
              <div class="card" style="width: 18rem;" >
                <a class="link-dark" href="{{ asset('/stylist/show/'.$stylist->id) }}" style="text-decoration: none" target="_blank">
                  <img src="{{ asset($stylist->icon) }}" class="card-img-top" alt="" height="300px" width="250px">
                  <div class="card-body">
                    <p class="card-text mb-1">{{ $stylist->name }}</p>
                    @if ($stylist->point)
                      <div class="col Stars card-text mb-1" style='--rating: {{$stylist->point}};' aria-label='Rating of this product is {{$stylist->point}} out of 5.'></div>
                    @else
                    <p class="card-text mb-1 text-end">-</p>                        
                    @endif
                    <p class="card-text mb-1 text-end">￥{{ $stylist->min_price?$stylist->min_price."~".$stylist->max_price : "-"}}</p>
                    <p class="card-text mb-1 text-start border-bottom">{{ $stylist->service }}</p>
                    <p class="card-text mb-1 text-start">{{ $stylist->area }}</p>
                  </div>
                </a>
              </div>
          </div>
        @endforeach
        </div>          
      </div>
    </div>

    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center">
        @if ($stylist_list->currentpage()-1)
          <li class="page-item">
              <a class="page-link border-0" href="{{ $stylist_list->previousPageUrl() }}" aria-label="Previous" >
                  <span aria-hidden="true" class="link-secondary">&#8249;</span>
              </a>
          </li>
          <li class="page-item"><a class="page-link link-secondary border-0" href="{{ $stylist_list->previousPageUrl() }}">{{ $stylist_list->currentPage() -1}}</a></li>
          @endif
          <li class="page-item"><span class="page-link link-secondary border-0" >{{ $stylist_list->currentPage() }}</span></li>
          @if ($stylist_list->currentpage()!=$stylist_list->lastPage())
          <li class="page-item"><a class="page-link link-secondary border-0" href="{{  $stylist_list->nextPageUrl()}}">{{ $stylist_list->currentPage() +1}}</a></li>
          <li class="page-item">            
              <a class="page-link border-0" href="{{  $stylist_list->nextPageUrl()}}" aria-label="Next">
                  <span aria-hidden="true" class="link-secondary">&#8250;</span>
              </a>
          </li>
          @endif
      </ul>
    </nav>
    @include('footer')
    <script>
      function form_submit(){
        document.getElementById('bar_form').submit();
      }
    </script>
</body>
</html>