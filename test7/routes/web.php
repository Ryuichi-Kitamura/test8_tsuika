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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/products', 'App\Http\Controllers\ProductController@showProducts')->name('products');
Route::get('/regist','App\Http\Controllers\ProductController@showRegistForm')->name('regist');
// 登録
Route::post('/regist','App\Http\Controllers\ProductController@registSubmit')->name('submit');
// 詳細
Route::get('/show/{id}', [ProductController::class, 'show'])->name('show');
// 削除
Route::post('/destroy{id}', [ProductController::class, 'destroy'])->name('destroy');
// 編集画面
Route::get('/edit/{id}','App\Http\Controllers\ProductController@showEditForm')->name('edit');
// 編集
Route::post('/edit/{id}','App\Http\Controllers\ProductController@update')->name('update');
