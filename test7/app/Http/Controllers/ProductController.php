<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function showProducts() {
        // インスタンス生成
        $model = new Product();
        $products = $model->getList();

        return view('products', ['products' => $products]);
    }

    public function showRegistForm() {
        return view('regist');
    }

    public function registSubmit(ProductRequest $request) {

        // トランザクション開始
        DB::beginTransaction();
    
        try {
            // 登録処理呼び出し
            $model = new Product();
            $model->registProduct($request);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }
    
        // 処理が完了したらregistにリダイレクト
        return redirect(route('regist'));
    }

    /**
     * 詳細画面の表示
     */
    public function show($id)
    {
        $model = new Product();
        $product = $model->getProduct($id);
        return view('show', compact('product'));
    }

    /**
     * 削除処理
     */
    public function destroy($id)
    {
        // Productsテーブルから指定のIDのレコード1件を取得
        $product = Product::find($id);
        // レコードを削除
        $product->delete();
        // 削除したら一覧画面にリダイレクト
        return redirect(route('products'));
    }

    /**
     * 編集画面の表示
     */
    public function showEditForm($id)
    {
        $product = Product::find($id);

        return view('edit', compact('product'));
    }

    /**
     * 更新処理
     */
    public function update(ProductRequest $request, $id)
    {
        // トランザクション開始
        DB::beginTransaction();
    
        try {
            // 登録処理呼び出し
            $product = Product::find($id);
            $product->updateProduct($request, $product);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }

        // 処理が完了したらeditにリダイレクト
        return redirect(route('edit', $id));
    }
}
