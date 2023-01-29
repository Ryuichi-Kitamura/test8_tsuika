<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Product extends Model
{
    use Sortable;
    // ソートを可能にするため結合先のテーブルのカラムを宣言
    public $sortableAs = ['company_name'];

    /**
     * 登録処理
     */
    public function registProduct($request) {
        // アップロードされたファイルの取得
        $image = $request->file('image');
        // ファイルの保存とパスの取得
        $path = isset($image) ? $image->store('images', 'public') : '';
        // セレクトボックスで選択されたメーカー
        $company = $this->getCompanyByName($request->companyName);
        // 登録
        DB::table('products')
        ->insert([
            'company_id' => $company->id,
            'product_name' => $request->productName,
            'price' => $request->price,
            'stock' => $request->stock,
            'comment' => $request->comment,
            'img_path' => $path,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * 更新処理
     */
    public function updateProduct($request, $product) {
        // アップロードされたファイルの取得
        $image = $request->file('image');
        // ファイルの保存とパスの取得
        $path = $product->img_path;
        if (isset($image)) {
            // 現在の画像ファイルの削除
            \Storage::disk('public')->delete($path);
            // 選択された画像ファイルを保存してパスをセット
            $path = $image->store('images', 'public');
        }
        // セレクトボックスで選択されたメーカー
        $company = $this->getCompanyByName($request->companyName);
        // 更新
        DB::table('products')
        ->where('id', $product->id)
        ->update([
            'company_id' => $company->id,
            'product_name' => $request->productName,
            'price' => $request->price,
            'stock' => $request->stock,
            'comment' => $request->comment,
            'img_path' => "$path",
            'updated_at' => now(),
        ]);
    }

    /**
     * productsテーブルから商品IDに一致するデータを1件取得
     */
    public function getProduct($id) {
        $product = DB::table('products')
        ->select('products.id', 'companies.id as company_id', 'companies.company_name', 'products.product_name',
        'products.price', 'products.stock', 'products.comment', 'products.img_path')
        ->where('products.id', '=', $id)
        ->join('companies', 'products.company_id', '=', 'companies.id')
        ->first();

        return $product;
    }

    /**
     * productsテーブルから商品IDに一致するデータの在庫数を取得
     */
    public function getStock($id) {
        $stock = DB::table('products')
        ->where('products.id', '=', $id)
        ->value('stock');

        return $stock;
    }

    /**
     * companiesテーブルから全データを取得
     */
    public function getAllCompanies() {
        $companies = DB::table('companies')
        ->select('companies.id', 'companies.company_name')
        ->orderBy("companies.id")
        ->get();

        return $companies;
    }

    /**
     * companiesテーブルからメーカー名に一致するデータを1件取得
     */
    public function getCompanyByName($companyName) {
        $company = DB::table('companies')
        ->select('companies.id', 'companies.company_name')
        ->where('companies.company_name', '=', $companyName)
        ->first();

        return $company;
    }

    /**
     * 検索処理
     */
    public function searchProducts($request) {
        // 検索フォームに入力された値を取得
        // 商品名
        $productName = $request->input('productName');
        // メーカー名
        $companyName = $request->input('companyName');
        // 価格(下限)
        $priceMin = $request->input('priceMin');
        // 価格(上限)
        $priceMax = $request->input('priceMax');
        // 在庫数(下限)
        $stockMin = $request->input('stockMin');
        // 在庫数(上限)
        $stockMax = $request->input('stockMax');

        $query = Product::query();
        // テーブル結合
        $query->join('companies', function ($query) use ($request) {
            $query->on('products.company_id', '=', 'companies.id');
            });
        // 一覧画面でソート可能にする
        $query->sortable();
        // 商品名の検索条件(部分一致)
        if(!empty($productName)) {
            $query->where('products.product_name', 'LIKE', "%{$productName}%");
        }
        // メーカー名の検索条件
        if(!empty($companyName)) {
            $query->where('companies.company_name', 'LIKE', $companyName);
        }
        // 価格(下限)の検索条件
        if(!empty($priceMin) || $priceMax == "0") {
            $query->where('price', '>=', $priceMin);
        }
        // 価格(上限)の検索条件
        if(!empty($priceMax) || $priceMax == "0") {
            $query->where('price', '<=', $priceMax);
        }
        // 在庫数(下限)の検索条件
        if(!empty($stockMin) || $stockMin == "0") {
            $query->where('stock', '>=', $stockMin);
        }
        // 在庫数(上限)の検索条件
        if(!empty($stockMax) || $stockMax == "0") {
            $query->where('stock', '<=', $stockMax);
        }

        // 検索条件に一致するデータを全て取得
        $products = $query
        ->select('products.id', 'companies.id as company_id', 'companies.company_name', 'products.product_name',
        'products.price', 'products.stock', 'products.comment', 'products.img_path')
        ->orderBy("products.id")
        ->get();

        return $products;
    }
}
