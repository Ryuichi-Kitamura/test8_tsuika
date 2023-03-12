<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    // ログイン時のみ表示する画面のルーティングをまとめて記載
    // 一覧画面
    Route::get('/products', 'App\Http\Controllers\ProductController@search')->name('search');
    // 登録画面
    Route::get('/regist','App\Http\Controllers\ProductController@showRegistForm')->name('regist');
    // 登録確認画面
    Route::get('/registConfirm','App\Http\Controllers\ProductController@showRegistConfirm')->name('showRegistConfirm');
    // 詳細画面
    Route::get('/detail/{id}', 'App\Http\Controllers\ProductController@showDetail')->name('detail');
    // 編集画面
    Route::get('/edit/{id}','App\Http\Controllers\ProductController@showEditForm')->name('edit');
});

// 検索
Route::post('/products', 'App\Http\Controllers\ProductController@searchProducts')->name('searchProducts');
// 削除
Route::post('/destroy{id}', 'App\Http\Controllers\ProductController@destroy')->name('destroy');
// 仮登録(登録確認画面へ)
Route::post('/regist','App\Http\Controllers\ProductController@registSubmit')->name('submit');
// 本登録
Route::post('/registConfirm','App\Http\Controllers\ProductController@registConfirm')->name('registConfirm');
// 編集
Route::post('/edit/{id}','App\Http\Controllers\ProductController@update')->name('update');
