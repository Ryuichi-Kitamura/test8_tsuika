@extends('layouts.app')

@section('title', '商品情報登録画面')

@section('content')
    <div class="container">
        <div>
            <h1>商品情報登録画面</h1>
            <form action="{{ route('submit') }}" method="post">
                @csrf

                <div class="form-group">
                    <label for="companyId">企業ID</label>
                    <input type="number" class="form-control" id="companyId" name="companyId" placeholder="企業ID">
                    @if($errors->has('companyId'))
                        <p>{{ $errors->first('companyId') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label for="productName">商品名</label>
                    <input type="text" class="form-control" id="productName" name="productName" placeholder="商品名">
                    @if($errors->has('productName'))
                        <p>{{ $errors->first('productName') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label for="price">価格</label>
                    <input type="number" class="form-control" id="price" name="price" placeholder="価格">
                    @if($errors->has('price'))
                        <p>{{ $errors->first('price') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label for="stock">在庫数</label>
                    <input type="number" class="form-control" id="stock" name="stock" placeholder="在庫数">
                    @if($errors->has('stock'))
                        <p>{{ $errors->first('stock') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label for="comment">コメント</label>
                    <textarea class="form-control" id="comment" name="comment" placeholder="コメント"></textarea>
                    @if($errors->has('comment'))
                        <p>{{ $errors->first('comment') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label for="imgPath">画像パス</label>
                    <input type="url" class="form-control" id="imgPath" name="imgPath" placeholder="画像パス">
                    @if($errors->has('imgPath'))
                        <p>{{ $errors->first('imgPath') }}</p>
                    @endif
                </div>

                <button type="submit" class="btn btn-success">登録</button>
            </form>
        </div>
        <a href="{{ route('search') }}" class="btn btn-secondary">戻る</a>
    </div>
@endsection