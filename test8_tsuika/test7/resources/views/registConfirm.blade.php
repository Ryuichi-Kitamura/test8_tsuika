@extends('layouts.app')

@section('title', '商品情報登録確認画面')

@section('content')
    <div class="container">
        <div>
            <h1>商品情報登録確認画面</h1>
            <form action="{{ route('registConfirm') }}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="form-group">
                    <label for="productName">商品名</label>
                    <input type="text" class="form-control" id="productName" name="productName" placeholder="商品名" value="{{ $session['productName'] }}" readonly>
                </div>
                <div class="form-group">
                    <label for="companyName">メーカー</label>
                    <input type="text" class="form-control" id="companyName" name="companyName" placeholder="メーカー" value="{{ $session['companyName'] }}" readonly>
                </div>
                <div class="form-group">
                    <label for="price">価格</label>
                    <input type="number" class="form-control" id="price" name="price" placeholder="価格" value="{{ $session['price'] }}" readonly>
                </div>
                <div class="form-group">
                    <label for="stock">在庫数</label>
                    <input type="number" class="form-control" id="stock" name="stock" placeholder="在庫数" value="{{ $session['stock'] }}" readonly>
                </div>
                <div class="form-group">
                    <label for="comment">コメント</label>
                    <textarea class="form-control" id="comment" name="comment" placeholder="コメント" readonly>{{ $session['comment'] }}</textarea>
                </div>
                <div class="form-group">
                    <label for="image">商品画像</label>
                    <input type="text" class="form-control" id="image" name="image" placeholder="画像パス" value="{{ $path }}" hidden>
                    @if ($path !=='')
                    <img src="storage/{{ $path }}">
                    @else
                    <p>no image</p>
                    @endif
                </div>

                <button type="submit" class="btn btn-success">登録</button>
            </form>
        </div>
    </div>
@endsection
