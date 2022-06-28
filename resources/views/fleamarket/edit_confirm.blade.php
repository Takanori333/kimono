<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- フォント読み込み -->
    <link href="https://fonts.googleapis.com/css2?family=Kaisei+Opti&family=Shippori+Mincho&display=swap" rel="stylesheet">
    <!-- CDN読み込み -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <title>晴 re 着 - 商品編集確認</title>
    <link rel="icon" type="image/x-icon" href="{{asset('/image/tagicon.png')}}">    
</head>

<body>
    {{-- ヘッダー --}}
    @include('header');

    <div class="container">
        <div class="contents pt-5 mt-5 w-75 mx-auto">
            <h2 class="text-center py-5 mt-5">商品編集</h2>

            {{-- 商品編集確認表示 --}}
            <div class="">
                <div class="row my-3">
                    <div class="col-sm-4 ">商品名</div>
                    <div class="col-sm-8">
                        <p class="">{{$item_infos["name"]}}
                        </p>
                    </div>
                </div>

                <div class="row my-3">
                    <div class="col-sm-4 ">商品画像</div>
                    <div class="col-sm-8">
                        @foreach ( $item_infos["image"] as $img )
                        @if ( explode('/', $img)[0] === 'image' )
                        <img src="{{asset($img)}}" class="w-25 m-1">
                        @else
                        <img src="{{$img}}" class="w-25 m-1">
                        @endif
                        @endforeach
                    </div>
                </div>

                <div class="row my-3">
                    <div class="col-sm-4 ">カテゴリ</div>
                    <div class="col-sm-8">
                        <p class="">{{$item_infos["category"]}}</p>
                    </div>
                </div>

                <div class="row my-3">
                    <div class="col-sm-4 ">値段</div>
                    <div class="col-sm-8">
                        <p class="">￥{{number_format($item_infos["price"])}}</p>
                    </div>
                </div>

                <div class="row my-3">
                    <div class="col-sm-4 ">発送元都道府県</div>
                    <div class="col-sm-8">
                        <p class="">{{$item_infos["pref"]}}</p>
                    </div>
                </div>

                <!-- <div class="row my-3">
                        <div class="col-sm-4 ">販売利益</div>
                        <div class="col-sm-8">
                            <p class="">￥200
                            <p>
                        </div>
                    </div> -->

                <div class="row my-3">
                    <div class="col-sm-4 ">素材</div>
                    <div class="col-sm-8">
                        <p class="">{{$item_infos["material"]}}</p>
                    </div>
                </div>

                <div class="row my-3">

                    <div class="col-sm-4 ">色</div>
                    <div class="col-sm-8">
                        <p class="">{{$item_infos["color"]}}</p>
                    </div>
                </div>

                <div class="row my-3">

                    <div class="col-sm-4 ">商品状態</div>
                    <div class="col-sm-8">
                        <p class="">{{$item_infos["status"]}}</p>
                    </div>
                </div>

                <div class="row my-3">

                    <div class="col-sm-4 ">におい</div>
                    <div class="col-sm-8">
                        <p class="">{{$item_infos["smell"]}}</p>
                    </div>
                </div>

                <div class="row my-3">

                    <div class="col-sm-4 ">サイズ</div>
                    <div class="col-sm-8">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="" class="d-inline">身丈</label>
                                <p class="d-inline">{{$item_infos["size_height"]}}cm</p>
                            </div>
                            <div class="col-sm-4">
                                <label for="" class="d-inline">裄</label>
                                <p class="d-inline">{{$item_infos["size_length"]}}cm</p>
                            </div>
                            <div class="col-sm-4">
                                <label for="" class="d-inline">袖丈</label>
                                <p class="d-inline">{{$item_infos["size_sleeve"]}}cm</p>
                            </div>
                            <div class="col-sm-4">
                                <label for="" class="d-inline">袖幅</label>
                                <p class="d-inline">{{$item_infos["size_sleeves"]}}cm</p>
                            </div>
                            <div class="col-sm-4">
                                <label for="" class="d-inline">前幅</label>
                                <p class="d-inline">{{$item_infos["size_front"]}}cm</p>
                            </div>
                            <div class="col-sm-4">
                                <label for="" class="d-inline">後ろ幅</label>
                                <p class="d-inline">{{$item_infos["size_back"]}}cm</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row my-3">

                    <div class="col-sm-4 ">自由記入欄</div>
                    <div class="col-sm-8">
                        <p>{{$item_infos["detail"]}}</p>
                    </div>
                </div>

                <form action="/fleamarket/update/{{$item_infos['id']}}" method="POST">
                    @csrf
                    <input type="hidden" name="name" value="{{ $item_infos['name'] }}">
                    @foreach ( $item_infos["image"] as $key => $img )
                        @if ( explode('/', $img)[0] === 'image' )
                        <input type="hidden" name="image[]" id="hidden_image_{{$key}}" class="hidden_image" value="{{asset($img)}}">
                        @else
                        <input type="hidden" name="image[]" id="hidden_image_{{$key}}" class="hidden_image" value="{{$img}}">
                        @endif
                    @endforeach
                    <input type="hidden" name="category" value="{{ $item_infos['category'] }}">
                    <input type="hidden" name="price" value="{{ $item_infos['price'] }}">
                    <input type="hidden" name="pref" value="{{ $item_infos['pref'] }}">
                    <input type="hidden" name="material" value="{{ $item_infos['material'] }}">
                    <input type="hidden" name="color" value="{{ $item_infos['color'] }}">
                    <input type="hidden" name="status" value="{{ $item_infos['status'] }}">
                    <input type="hidden" name="smell" value="{{ $item_infos['smell'] }}">
                    <input type="hidden" name="size_height" value="{{ $item_infos['size_height'] }}">
                    <input type="hidden" name="size_length" value="{{ $item_infos['size_length'] }}">
                    <input type="hidden" name="size_sleeve" value="{{ $item_infos['size_sleeve'] }}">
                    <input type="hidden" name="size_sleeves" value="{{ $item_infos['size_sleeves'] }}">
                    <input type="hidden" name="size_front" value="{{ $item_infos['size_front'] }}">
                    <input type="hidden" name="size_back" value="{{ $item_infos['size_back'] }}">
                    <input type="hidden" name="detail" value="{{ $item_infos['detail'] }}">
                    
                    
                    <div class="row w-50 mx-auto">
                        <div class="col-sm my-2">
                            <div class="d-grid justify-content-center">
                                <button name="back" type="submit" value="true" class="btn btn-secondary rounded-0" style="width: 60px;">戻る</button>
                            </div>
                        </div>
                        <div class="col-sm my-2">
                            <div class="d-grid justify-content-center">
                                <button name="regist" type="submit" value="true" class="btn btn-secondary rounded-0" style="width: 60px;">登録</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- <div>
        <p>商品名:{{$item_infos["name"]}}</p>
        <p>商品画像: </p>
        @foreach ( $item_infos["image"] as $img )
        @if ( explode('/', $img)[0] === 'image' )
        <img src="{{asset($img)}}">
        @else
        <img src="{{$img}}">
        @endif
        @endforeach
        <p>カテゴリ:{{$item_infos["category"]}}</p>
        <p>値段:{{$item_infos["price"]}}</p>
        <p>発送元都道府県:{{$item_infos["pref"]}}</p>
        <p>素材:{{$item_infos["material"]}}</p>
        <p>色:{{$item_infos["color"]}}</p>
        <p>商品状態:{{$item_infos["status"]}}</p>
        <p>におい:{{$item_infos["smell"]}}</p>
        <p>身丈:{{$item_infos["size_height"]}}</p>
        <p>裄丈:{{$item_infos["size_length"]}}</p>
        <p>袖丈:{{$item_infos["size_sleeve"]}}</p>
        <p>袖幅:{{$item_infos["size_sleeves"]}}</p>
        <p>前幅:{{$item_infos["size_front"]}}</p>
        <p>後幅:{{$item_infos["size_back"]}}</p>
        <p>自由記入:{{$item_infos["detail"]}}</p>

        <form action="/fleamarket/update/{{$item_infos["id"]}}" method="POST">
            @csrf
            <input type="hidden" name="name" value="{{ $item_infos["name"] }}">
            @foreach ( $item_infos["image"] as $img )
            <input type="hidden" name="image[]" value="{{ $img }}">
            @endforeach
            <input type="hidden" name="category" value="{{ $item_infos["category"] }}">
            <input type="hidden" name="price" value="{{ $item_infos["price"] }}">
            <input type="hidden" name="pref" value="{{ $item_infos["pref"] }}">
            <input type="hidden" name="material" value="{{ $item_infos["material"] }}">
            <input type="hidden" name="color" value="{{ $item_infos["color"] }}">
            <input type="hidden" name="status" value="{{ $item_infos["status"] }}">
            <input type="hidden" name="smell" value="{{ $item_infos["smell"] }}">
            <input type="hidden" name="size_height" value="{{ $item_infos["size_height"] }}">
            <input type="hidden" name="size_length" value="{{ $item_infos["size_length"] }}">
            <input type="hidden" name="size_sleeve" value="{{ $item_infos["size_sleeve"] }}">
            <input type="hidden" name="size_sleeves" value="{{ $item_infos["size_sleeves"] }}">
            <input type="hidden" name="size_front" value="{{ $item_infos["size_front"] }}">
            <input type="hidden" name="size_back" value="{{ $item_infos["size_back"] }}">
            <input type="hidden" name="detail" value="{{ $item_infos["detail"] }}">

            <button name="back" type="submit" value="true">戻る</button>
            <button name="regist" type="submit" value="true">登録</button>
        </form>
    </div> -->

    @include('footer')

    <script>
        $(document).ready( function(){
            let temp_images = document.getElementsByClassName('hidden_image');
            let images = Object.keys(temp_images).map(function (key) {return [temp_images[key]];});
            images.forEach(function(e, i){
                e.forEach(function(ee, ii){
                    toBase64Url(ee.value, function(base64Url){
                        document.getElementById(ee.id).value = base64Url;
                    });
                });
            });
        });

        function toBase64Url(url, callback){
            let xhr = new XMLHttpRequest();
            xhr.onload = function() {
                let reader = new FileReader();
                reader.onloadend = function() {
                callback(reader.result);
                }
                reader.readAsDataURL(xhr.response);
            };
            xhr.open('GET', url);
            xhr.responseType = 'blob';
            xhr.send();
        }


    </script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>