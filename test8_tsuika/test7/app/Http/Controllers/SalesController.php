<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Exceptions\HttpResponseException;

class SalesController extends Controller
{
    /**
     * 購入処理
     */
    public function buy(Request $request)
    {
        // 商品ID
        $productId = $request->input("productId");

        // IDに一致するデータを1件取得
        $model = new Product();
        $product = $model->getProduct($productId);

        if ($product !== null) {
            // 在庫数
            $stock = $model->getStock($productId);

            if ($stock > 0) {
                // トランザクション開始
                DB::beginTransaction();
                try {
                    // 購入処理呼び出し
                    $model = new Sale();
                    $model->buy($request);
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();
                    return back();
                }

                $result = [
                    "結果" => "ID「" . $productId . "」の商品を購入しました。",
                    "入力した商品ID" => $productId,
                    "購入後の在庫数" => $stock -1,
                ];
            } else {
                $result = [
                    "結果" => "在庫が不足しています。",
                ];
            }
        } else {
            $result = [
                "結果" => "ID「" . $productId . "」に一致する商品が見つかりませんでした。",
            ];
        }

        // 結果の表示
        return response()->json($result);
    }
}
