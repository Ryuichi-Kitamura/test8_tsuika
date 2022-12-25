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
        // 全メーカーを取得
        $companies = DB::table('companies')
        ->select('companies.id', 'companies.company_name')
        ->orderBy("companies.id")
        ->get();

        return view('regist', compact('companies'));
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
        // ファイルの保存とパスの取得
        $path = $product->img_path;
        if ($path !== '') {
            // 現在の画像ファイルの削除
            \Storage::disk('public')->delete($path);
        }
        // レコードを削除
        $product->delete();
        // 削除したら一覧画面にリダイレクト
        return redirect(route('search'));
    }

    /**
     * 編集画面の表示
     */
    public function showEditForm($id)
    {
        $model = new Product();
        $product = $model->getProduct($id);

        // 全メーカーを取得
        $companies = DB::table('companies')
        ->select('companies.id', 'companies.company_name')
        ->orderBy("companies.id")
        ->get();

        return view('edit', compact('product', 'companies'));
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

    /**
     * 検索処理
     */
    public function searchProducts(Request $request)
    {
        //検索フォームに入力された値を取得
        $productName = $request->input('productName');
        $companyName = $request->input('companyName');

        $query = Product::query();
        //テーブル結合
        $query->join('companies', function ($query) use ($request) {
            $query->on('products.company_id', '=', 'companies.id');
            });

        if(!empty($productName)) {
            $query->where('products.product_name', 'LIKE', "%{$productName}%");
        }

        if(!empty($companyName)) {
            $query->where('companies.company_name', 'LIKE', $companyName);
        }

        $products = $query
        ->select('products.id', 'companies.id as company_id', 'companies.company_name', 'products.product_name',
        'products.price', 'products.stock', 'products.comment', 'products.img_path')
        ->get();

        // 全メーカーを取得
        $companies = DB::table('companies')
        ->select('companies.id', 'companies.company_name')
        ->orderBy("companies.id")
        ->get();

        return view('products', compact('products', 'companies', 'productName', 'companyName'));
    }
}
