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

    public function registProduct($data) {
        // 登録処理
        DB::table('products')->insert([
            'company_id' => $data->companyId,
            'product_name' => $data->productName,
            'price' => $data->price,
            'stock' => $data->stock,
            'comment' => $data->comment,
            'img_path' => $data->imgPath,
        ]);
    }
}
