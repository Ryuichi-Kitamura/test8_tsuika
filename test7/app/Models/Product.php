<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    public function getList() {
        // productsテーブルからデータを取得
        $products = DB::table('products')
        ->select('products.id', 'companies.id as company_id', 'companies.company_name', 'products.product_name',
        'products.price', 'products.stock', 'products.comment', 'products.img_path')
        ->join('companies', 'products.company_id', '=', 'companies.id')
        ->orderBy("products.id")
        ->get();

        return $products;
    }

    public function getProduct($id) {
        // productsテーブルから商品IDに一致するデータを1件取得
        $product = DB::table('products')
        ->select('products.id', 'companies.id as company_id', 'companies.company_name', 'products.product_name',
        'products.price', 'products.stock', 'products.comment', 'products.img_path')
        ->where('products.id', '=', $id)
        ->join('companies', 'products.company_id', '=', 'companies.id')
        ->first();

        return $product;
    }

    public function registProduct($data) {
        // 登録処理

        $company = $this->getCompanyByName($data->companyName);

        DB::table('products')
        ->insert([
            'company_id' => $company->id,
            'product_name' => $data->productName,
            'price' => $data->price,
            'stock' => $data->stock,
            'comment' => $data->comment,
            'img_path' => $data->imgPath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * 更新処理
     */
    public function updateProduct($request, $product) {
        $company = $this->getCompanyByName($request->companyName);

        DB::table('products')
        ->where('id', $product->id)
        ->update([
            'company_id' => $company->id,
            'product_name' => $request->productName,
            'price' => $request->price,
            'stock' => $request->stock,
            'comment' => $request->comment,
            'img_path' => $request->imgPath,
            'updated_at' => now(),
        ]);
    }

    public function getCompanyByName($companyName) {
        // companiesテーブルからメーカー名に一致するデータを1件取得
        $company = DB::table('companies')
        ->select('companies.id', 'companies.company_name')
        ->where('companies.company_name', '=', $companyName)
        ->first();

        return $company;
    }
}
