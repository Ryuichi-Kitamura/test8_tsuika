@extends('layouts.app')

@section('title', '商品情報登録画面')

@section('content')
    <div class="container">
        <div>
            <h1>商品情報登録画面</h1>
            <form action="{{ route('submit') }}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="form-group">
                    <label for="productName">商品名</label>
                    <input type="text" class="form-control" id="productName" name="productName" placeholder="商品名" value="{{ old('productName') }}">
                    @if($errors->has('productName'))
                        <p>{{ $errors->first('productName') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label for="companyName">メーカー</label>
                    <select class="form-control" id="companyName" name="companyName" placeholder="メーカー" value="{{ old('companyName') }}">
                        <option value="" disabled selected></option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->company_name }}">{{ $company->company_name }}</option>
                    @endforeach
                    </select>
                    @if($errors->has('companyName'))
                        <p>{{ $errors->first('companyName') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label for="price">価格</label>
                    <input type="number" class="form-control" id="price" name="price" placeholder="価格" value="{{ old('price') }}">
                    @if($errors->has('price'))
                        <p>{{ $errors->first('price') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label for="stock">在庫数</label>
                    <input type="number" class="form-control" id="stock" name="stock" placeholder="在庫数" value="{{ old('stock') }}">
                    @if($errors->has('stock'))
                        <p>{{ $errors->first('stock') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label for="comment">コメント</label>
                    <textarea class="form-control" id="comment" name="comment" placeholder="コメント">{{ old('comment') }}</textarea>
                    @if($errors->has('comment'))
                        <p>{{ $errors->first('comment') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label for="image">商品画像</label>
                    <input type="file" class="form-control" id="image" name="image">
                    @if($errors->has('image'))
                        <p>{{ $errors->first('image') }}</p>
                    @endif
                </div>

                <button type="submit" class="btn btn-success">登録</button>
            </form>
        </div>
        <a href="{{ route('search') }}" class="btn btn-secondary">戻る</a>
    </div>
@endsection
