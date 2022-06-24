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
    <title>和服フリマ（仮）- 商品編集</title>
</head>
<body>
    {{-- ヘッダー --}}
    @include('header');

    <div class="container">
        <div class="contents pt-5 mt-5 w-75 mx-auto">

            <h2 class="text-center py-5 mt-5">商品編集</h2>

            {{-- 商品登録フォーム --}}
            <div class="">
                <form action="/fleamarket/edit/{{$item_info['id']}}" method="POST" enctype="multipart/form-data" id="item_create_form" class="">
                    @csrf
                    <!-- @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach -->
                    <div class="row my-3">
                        <div class="col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('name') as $msg)
                            <small class="text-danger d-block mb-1">{{ $msg }}</small>
                            @endforeach
                        </div>
                        <div class="col-sm-4 col-form-label">商品名</div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control rounded-0" name="name" value="{{ old('name', $item_info['name']) }}">
                        </div>
                    </div>    
                    
                    @php
                    $images = old("image", $item_images);
                    @endphp
                    <div class="row my-3">
                        <div class="col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('image') as $msg)
                            <small class="text-danger d-block mb-1">{{ $msg }}</small>
                            @endforeach
                        </div>
                        <div class="col-sm-4 col-form-label">商品画像</div>
                        <div class="col-sm-8">
                            <div id="show_img_area">
                                <!-- 設定済画像表示 -->
                                @isset( $images )
                                @foreach ($images as $image )
                                @if ( explode('/',  $image)[0] === 'image' )
                                <img src="{{asset($image)}}" class="w-25 mb-1">
                                @else
                                <img src="{{$image}}" class="w-25 mb-1">
                                @endif
                                @endforeach
                                @endisset
                            </div>
                            <input type="file" name="" id="input_img" class="form-control rounded-0" multiple>
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('category') as $msg)
                            <small class="text-danger d-block mb-1">{{ $msg }}</small>
                            @endforeach
                        </div>
                        <div class="col-sm-4 col-form-label">カテゴリ</div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control rounded-0" name="category" value="{{ old('category', $item_info['category']) }}">
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('price') as $msg)
                            <small class="text-danger d-block mb-1">{{ $msg }}</small>
                            @endforeach
                        </div>
                        <div class="col-sm-4 col-form-label">値段</div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control rounded-0" name="price" value="{{ old('price', $item_info['price']) }}">
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('pref') as $msg)
                            <small class="text-danger d-block mb-1">{{ $msg }}</small>
                            @endforeach
                        </div>
                        <div class="col-sm-4 col-form-label">発送元都道府県</div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control rounded-0" name="pref" value="{{ old('pref', $item_info['area']) }}">
                        </div>
                    </div>

                    <!-- <div class="row my-3">
                        <div class="col-sm-8 offset-md-4">
                            バリデーションメッセージ
                            @foreach ($errors->get('') as $msg)
                            <small class="text-danger d-block mb-1">{{ $msg }}</small>
                            @endforeach
                        </div>
                        <div class="col-sm-4 col-form-label">販売利益</div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control rounded-0" value="">
                        </div>
                    </div> -->

                    <div class="row my-3">
                        <div class="col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('material') as $msg)
                            <small class="text-danger d-block mb-1">{{ $msg }}</small>
                            @endforeach
                        </div>
                        <div class="col-sm-4 col-form-label">素材</div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control rounded-0" name="material" value="{{ old('material', $item_info['material']) }}">
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('color') as $msg)
                            <small class="text-danger d-block mb-1">{{ $msg }}</small>
                            @endforeach
                        </div>
                        <div class="col-sm-4 col-form-label">色</div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control rounded-0" name="color" value="{{ old('color', $item_info['color']) }}">
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('item_status') as $msg)
                            <small class="text-danger d-block mb-1">{{ $msg }}</small>
                            @endforeach
                        </div>
                        <div class="col-sm-4 col-form-label">商品状態</div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control rounded-0" name="status" value="{{ old('status', $item_info['item_status']) }}">
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('smell') as $msg)
                            <small class="text-danger d-block mb-1">{{ $msg }}</small>
                            @endforeach
                        </div>
                        <div class="col-sm-4 col-form-label">におい</div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control rounded-0" name="smell" value="{{ old('smell', $item_info['smell']) }}">
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('size_height') as $msg)
                            <small class="text-danger d-block mb-1">{{ $msg }}</small>
                            @endforeach
                            @foreach ($errors->get('size_length') as $msg)
                            <small class="text-danger d-block mb-1">{{ $msg }}</small>
                            @endforeach
                            @foreach ($errors->get('size_sleeve') as $msg)
                            <small class="text-danger d-block mb-1">{{ $msg }}</small>
                            @endforeach
                            @foreach ($errors->get('size_sleeves') as $msg)
                            <small class="text-danger d-block mb-1">{{ $msg }}</small>
                            @endforeach
                            @foreach ($errors->get('size_front') as $msg)
                            <small class="text-danger d-block mb-1">{{ $msg }}</small>
                            @endforeach
                            @foreach ($errors->get('size_back') as $msg)
                            <small class="text-danger d-block mb-1">{{ $msg }}</small>
                            @endforeach
                        </div>
                        <div class="col-sm-4 col-form-label">サイズ</div>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="" class="col-form-label">身丈</label>
                                    <div class=""><input type="text" class="form-control rounded-0" name="size_height" value="{{ old('size_height', $item_info['height']) }}"></div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="" class="col-form-label">裄</label>
                                    <div class=""><input type="text" class="form-control rounded-0" name="size_length" value="{{ old('size_length', $item_info['length']) }}"></div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="" class="col-form-label">袖丈</label>
                                    <div class=""><input type="text" class="form-control rounded-0" name="size_sleeve" value="{{ old('size_sleeve', $item_info['sleeve']) }}"></div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="" class="col-form-label">袖幅</label>
                                    <div class=""><input type="text" class="form-control rounded-0" name="size_sleeves" value="{{ old('size_sleeves', $item_info['sleeves']) }}"></div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="" class="col-form-label">前幅</label>
                                    <div class=""><input type="text" class="form-control rounded-0" name="size_front" value="{{ old('size_front', $item_info['front']) }}"></div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="" class="col-form-label">後ろ幅</label>
                                    <div class=""><input type="text" class="form-control rounded-0" name="size_back" value="{{ old('size_back', $item_info['back']) }}"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="col-sm-8 offset-md-4">
                            <!-- バリデーションメッセージ -->
                            @foreach ($errors->get('detail') as $msg)
                            <small class="text-danger d-block mb-1">{{ $msg }}</small>
                            @endforeach
                        </div>
                        <div class="col-sm-4 col-form-label">自由記入欄</div>
                        <div class="col-sm-8">
                            <textarea name="detail" id="" class="form-control rounded-0" cols="30" rows="10">{{ old("detail", $item_info["detail"]) }}</textarea>
                        </div>
                    </div>

                    <div id="hidden_input">
                        <input type="hidden" name="id" value="{{ $item_info['id'] }}">
                        @isset( $images )
                        @foreach ($images as $key => $image )
                        <input type="hidden" name="image[{{$key}}]" value="{{ $image }}">
                        @endforeach
                        @endisset
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-secondary rounded-0">内容を確認</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('footer')

    <script>
        // <input type="file" id="input_img" multiple>にchangeイベントを設定
        document.getElementById( "input_img" ).addEventListener( "change", function() {
            // フォームで選択された全ファイルを取得
            let fileList = this.files ;

            // 個数分の画像を表示する
            for( let i=0,l=fileList.length; l>i; i++ ) {
                // FileReaderオブジェクトを作成
                let fileReader = new FileReader() ;

                // 読み込み後の処理を決めておく
                fileReader.onload = function() {
                    // Data URIを取得
                    let dataUri = this.result ;
                    // サンプルを表示する領域を取得
                    let show_img = document.getElementById("show_img_area");
                    // HTMLに書き出し (src属性にData URIを指定)
                    show_img.innerHTML += '<img src="' + dataUri + '">'
                    
                    // inputタグをhiddenで表示するdivタグを取得する
                    let hidden_area = document.getElementById("hidden_input");
                    hidden_area.innerHTML += '<input type="hidden" name="image[]" value="' + dataUri +'">'
                    console.log( '<input type="hidden" name="image[]" value="' + dataUri +'">');
                }
                // ファイルをData URIとして読み込む
                fileReader.readAsDataURL( fileList[i] ) ;
            }
        } ) ;


    </script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>