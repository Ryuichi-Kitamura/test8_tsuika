<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    /**
     * 購入処理
     */
    public function buy($request) {
        // salesテーブルにレコードを追加
        DB::table('sales')
        ->insert([
            'product_id' => $request->productId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // productsテーブルの該当レコードの在庫数を-1
        DB::table('products')
        ->where('id', $request->productId)
        ->update([
            'stock' => DB::raw('stock -1'),
            'updated_at' => now(),
        ]);
    }
}
