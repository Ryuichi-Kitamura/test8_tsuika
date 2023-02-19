<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * 登録画面の表示
     */
    public function showRegistForm() {
        // 全メーカーを取得
        $model = new Product();
        $companies = $model->getAllCompanies();

        return view('regist', compact('companies'));
    }

    /**
     * 詳細画面の表示
     */
    public function showDetail($id)
    {
        // IDに一致するデータを1件取得
        $model = new Product();
        $product = $model->getProduct($id);
        return view('detail', compact('product'));
    }

    /**
     * 編集画面の表示
     */
    public function showEditForm($id)
    {
        $model = new Product();
        $product = $model->getProduct($id);

        // 全メーカーを取得
        $model = new Product();
        $companies = $model->getAllCompanies();

        return view('edit', compact('product', 'companies'));
    }

    /**
     * 仮登録処理
     */
    public function registSubmit(ProductRequest $request) {
        // アップロードされたファイルの取得
        $image = $request->file('image');
        // ファイルの保存とパスの取得
        $path = isset($image) ? $image->store('images', 'public') : '';
        // リクエストからセッションの値を取得
        $request->session()->put('productName', $request->productName);
        $request->session()->put('companyName', $request->companyName);
        $request->session()->put('price', $request->price);
        $request->session()->put('stock', $request->stock);
        $request->session()->put('comment', $request->comment);
        $session = $request->session()->all();

        return view('registConfirm', compact('session', 'path'));
    }

    /**
     * 本登録処理
     */
    public function registConfirm(Request $request) {
        // リクエストからセッションを保持
        $request->session()->put('productName', $request->productName);
        $request->session()->put('companyName', $request->companyName);
        $request->session()->put('price', $request->price);
        $request->session()->put('stock', $request->stock);
        $request->session()->put('comment', $request->comment);
        $request->session()->put('image', $request->image);
        $session = $request->session()->all();
        // トランザクション開始
        DB::beginTransaction();
    
        try {
            // 登録処理呼び出し
            $model = new Product();
            $model->registProduct($session);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }
    
        // 処理が完了したらsearchにリダイレクト
        return redirect(route('search'));
    }

    /**
     * 更新処理
     */
    public function update(ProductRequest $request, $id)
    {
        // トランザクション開始
        DB::beginTransaction();
    
        try {
            // 更新処理呼び出し
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
    }

    /**
     * 一覧画面の表示
     */
    public function search(Request $request)
    {
        // 検索結果を取得
        $model = new Product();
        $products = $model->searchProducts($request);

        // 全メーカーを取得
        $model = new Product();
        $companies = $model->getAllCompanies();

        return view('products', compact('products', 'companies'));
    }

    /**
     * Ajaxによる検索処理
     */
    public function searchProducts(Request $request)
    {
        // 検索結果を取得
        $model = new Product();
        $products = $model->searchProducts($request);

        return response()->json($products);
    }
}
