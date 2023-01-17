@extends('layouts.app')

@section('title', '商品情報一覧画面')

@section('content')
    <div class="container">
        <h1>商品情報一覧画面</h1>
        <div class="search">
            <form action="{{ route('search') }}" method="GET">
            @csrf
                <div class="form-group">
                    <div class="row">
                        <label for="productName">商品名</label>
                            <div class="col-auto">
                                <input type="text" class="form-control" id="productName" name="productName">
                            </div>
                        </label>
                    </div>

                    <div class="row">
                        <label for="companyName">メーカー名</label>
                            <div class="col-auto">
                                <select class="form-control" id="companyName" name="companyName" data-toggle="select">
                                    <option value="">全て</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->company_name }}">{{ $company->company_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </label>
                    </div>

                    <div class="row">
                        <label for="price">価格(下限〜上限)</label>
                            <div class="col-auto">
                                <input type="number" class="form-control" id="priceMin" name="priceMin">
                            </div>
                            <div class="col-auto">
                                <p>〜</p>
                            </div>
                            <div class="col-auto">
                                <input type="number" class="form-control" id="priceMax" name="priceMax">
                            </div>
                        </label>
                    </div>

                    <div class="row">
                        <label for="stock">在庫数(下限〜上限)</label>
                            <div class="col-auto">
                                <input type="number" class="form-control" id="stockMin" name="stockMin">
                            </div>
                            <div class="col-auto">
                                <p>〜</p>
                            </div>
                            <div class="col-auto">
                                <input type="number" class="form-control" id="stockMax" name="stockMax">
                            </div>
                        </label>
                    </div>

                    <div>
                        <input type="submit" class="btn btn-dark" value="検索">
                    </div>
                    <div>
                        <input type="button" class="btn btn-dark" id="narrowDownButton" value="検索(jQuery)">
                    </div>
                </div>
            </form>
        </div>

        <div>
            <a href="{{ route('regist') }}" class="btn btn-success">新規登録</a>
        </div>

        <table class="table table-striped" id="resultTable">
            <thead>
                <tr>
                    <th>@sortablelink ('id', '商品ID')</th>
                    <th>@sortablelink ('img_path', '商品画像')</th>
                    <th>@sortablelink ('product_name', '商品名')</th>
                    <th>@sortablelink ('price', '価格')</th>
                    <th>@sortablelink ('stock', '在庫数')</th>
                    <th>@sortablelink ('comment', 'コメント')</th>
                    <th>@sortablelink ('company_name', 'メーカー名')</th>
                    <th>詳細表示ボタン</th>
                    <th>削除ボタン</th>
                    <th>削除ボタン(jQuery)</th>
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
                    <td id="resultProductName">{{ $product->product_name }}</td>
                    <td id="resultPrice">{{ $product->price }}</td>
                    <td id="resultStock">{{ $product->stock }}</td>
                    <td>{{ $product->comment }}</td>
                    <td id="resultCompanyName">{{ $product->company_name }}</td>
                    <td><a href="{{ route('detail', ['id'=>$product->id]) }}" class="btn btn-primary">詳細表示</a></td>
                    <td>
                        <form action="{{ route('destroy', ['id'=>$product->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger" onClick="delete_alert(event);return false;">削除</button>
                        </form>
                    </td>
                    <td><input type="button" class="btn btn-danger" id="deleteButton" value="削除(jQuery)"></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
