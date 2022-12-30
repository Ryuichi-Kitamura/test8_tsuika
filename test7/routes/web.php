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
    Route::get('/products', 'App\Http\Controllers\ProductController@searchProducts')->name('search')->middleware('auth');
    // 登録画面
    Route::get('/regist','App\Http\Controllers\ProductController@showRegistForm')->name('regist')->middleware('auth');
    // 詳細画面
    Route::get('/detail/{id}', 'App\Http\Controllers\ProductController@showDetail')->name('detail')->middleware('auth');
    // 編集画面
    Route::get('/edit/{id}','App\Http\Controllers\ProductController@showEditForm')->name('edit')->middleware('auth');
});

// 削除
Route::post('/destroy{id}', 'App\Http\Controllers\ProductController@destroy')->name('destroy');
// 登録
Route::post('/regist','App\Http\Controllers\ProductController@registSubmit')->name('submit');
// 編集
Route::post('/edit/{id}','App\Http\Controllers\ProductController@update')->name('update');
