@extends('layouts.app')

@section('title', '商品情報詳細画面')

@section('content')
<div class="container">
<h1>商品情報詳細画面</h1>
<table class="table table-striped">
    <thead>
        <tr>
            <th>商品情報ID</th>
            <th>商品画像</th>
            <th>商品名</th>
            <th>メーカー</th>
            <th>価格</th>
            <th>在庫数</th>
            <th>コメント</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $product->id }}</td>
            <td><img src="{{ $product->img_path }}"></td>
            <td>{{ $product->product_name }}</td>
            <td>{{ $product->company_name }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->stock }}</td>
            <td>{{ $product->comment }}</td>
        </tr>
    </tbody>
</table>
<div>
    <a href="{{ route('edit', ['id'=>$product->id]) }}" class="btn btn-info">編集</a>
</div>
<div>
    <a href="{{ route('search') }}" class="btn btn-secondary">戻る</a>
</div>
</div>
@endsection