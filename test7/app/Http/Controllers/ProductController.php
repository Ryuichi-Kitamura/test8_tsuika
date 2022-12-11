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
     * 削除処理
     */
    public function destroy($id)
    {
        // Productsテーブルから指定のIDのレコード1件を取得
        $Product = Product::find($id);
        // レコードを削除
        $Product->delete();
        // 削除したら一覧画面にリダイレクト
        return redirect(route('products'));
    }
}
