@extends('layouts.app')

@section('title', '商品情報編集画面')

@section('content')
    <div class="container">
        <div>
            <h1>商品情報編集画面</h1>
            <form action="{{ route('edit', $product->id) }}" enctype="multipart/form-data" method="post">
                <div>
                    商品情報ID : {{ $product->id }}
                </div>
                @csrf
                <div class="form-group">
                    <label for="productName">商品名</label>
                    <input type="text" class="form-control" id="productName" name="productName" placeholder="商品名" value="{{ $product->product_name }}">
                    @if($errors->has('productName'))
                        <p>{{ $errors->first('productName') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label for="companyName">メーカー</label>
                    <select class="form-control" id="companyName" name="companyName" placeholder="メーカー" value="{{ $product->company_name }}">
                    @foreach ($companies as $company)
                        <option>{{ $company->company_name }}</option>
                    @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="price">価格</label>
                    <input type="number" class="form-control" id="price" name="price" placeholder="価格" value="{{ $product->price }}">
                    @if($errors->has('price'))
                        <p>{{ $errors->first('price') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label for="stock">在庫数</label>
                    <input type="number" class="form-control" id="stock" name="stock" placeholder="在庫数" value="{{ $product->stock }}">
                    @if($errors->has('stock'))
                        <p>{{ $errors->first('stock') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label for="comment">コメント</label>
                    <textarea class="form-control" id="comment" name="comment" placeholder="コメント">{{ $product->comment }}</textarea>
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

                <button type="submit" class="btn btn-info">更新</button>
            </form>
        </div>
        <a href="{{ route('detail', ['id'=>$product->id]) }}" class="btn btn-secondary">戻る</a>
    </div>
@endsection
