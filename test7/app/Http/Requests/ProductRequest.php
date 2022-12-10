<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'companyId' => 'required | integer',
            'productName' => 'required | max:255',
            'price' => 'required | integer',
            'stock' => 'required | integer',
            'comment' => 'max:10000',
            'imgPath' => 'required | max:255 | url',
        ];
    }

    /**
     * 項目名
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'companyId' => '企業ID',
            'productName' => '商品名',
            'price' => '値段',
            'stock' => '在庫',
            'comment' => 'コメント',
            'imgPath' => '画像パス',
        ];
    }

    /**
     * エラーメッセージ
     *
     * @return array
     */
    public function messages() {
        return [
            'companyId.required' => ':attributeは必須項目です。',
            'productName.required' => ':attributeは必須項目です。',
            'price.required' => ':attributeは必須項目です。',
            'stock.required' => ':attributeは必須項目です。',
            'imgPath.required' => ':attributeは必須項目です。',

            'productName.max' => ':attributeは:max字以内で入力してください。',
            'comment.max' => ':attributeは:max字以内で入力してください。',
            'imgPath.max' => ':attributeは:max字以内で入力してください。',
            
            'companyId.required' => ':attributeは整数で入力してください。',
            'price.required' => ':attributeは整数で入力してください。',
            'stock.required' => ':attributeは整数で入力してください。',

            'imgPath.url' => ':attributeはURL形式で入力してください。',
        ];
    }
}
