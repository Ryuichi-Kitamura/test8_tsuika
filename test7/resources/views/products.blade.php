@extends('layouts.app')

@section('title', '商品情報一覧画面')

@section('content')
    <div class="container">
        <h1>商品情報一覧画面</h1>
        <div class="search">
            <form action="{{ route('search') }}" method="GET">
            @csrf
                <div class="form-group">
                    <div>
                        <label for="productName">商品名</label>
                            <div>
                                <input type="text" class="form-control" id="productName" name="productName">
                            </div>
                        </label>
                    </div>

                    <div>
                        <label for="companyName">メーカー名</label>
                            <div>
                                <select class="form-control" id="companyName" name="companyName" data-toggle="select">
                                    <option value="">全て</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->company_name }}">{{ $company->company_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </label>
                    </div>

                    <div>
                        <input type="submit" class="btn btn-dark" value="検索">
                    </div>
                </div>
            </form>
        </div>

        <div>
            <a href="{{ route('regist') }}" class="btn btn-success">新規登録</a>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>商品ID</th>
                    <th>商品画像</th>
                    <th>商品名</th>
                    <th>価格</th>
                    <th>在庫数</th>
                    <th>コメント</th>
                    <th>メーカー名</th>
                    <th>詳細表示ボタン</th>
                    <th>削除ボタン</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                        @if ($product->img_path !=='')
                        <img src="{{ asset('storage/'.$product->img_path)}}">
                        @else
                        <p>no image</p>
                        @endif
                    </td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->comment }}</td>
                    <td>{{ $product->company_name }}</td>
                    <td><a href="{{ route('detail', ['id'=>$product->id]) }}" class="btn btn-primary">詳細表示</a></td>
                    <td>
                        <form action="{{ route('destroy', ['id'=>$product->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger" onClick="delete_alert(event);return false;">削除</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
