<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Change this if you have specific authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        
        $productId = $this->route('id');

        return [
            'name'               => 'required|string|max:255|unique:products,name,' . $productId,
            'code'               => 'required|string|max:255|unique:products,code,' . $productId,
            'category_id'        => 'required|exists:categories,id',
            'stock'              => 'required|integer|min:0',
            'price_regular'      => 'required|numeric|min:0',
            'price_sale'         => 'nullable|numeric|min:0|lt:price_regular',
            'warranty_period'    => 'nullable|integer|min:0',
            'content'            => 'required|string',
            'short_description'   =>'nullable',
            'meta_title'          =>'nullable|max:255',
            'meta_description'    =>'nullable',
            'is_active'          => 'boolean',
            'is_hot_deal'        => 'boolean',
            'is_show_home'       => 'boolean',
            'is_new'             => 'boolean',
            'is_good_deal'       => 'boolean',
            'coupon'             => 'nullable|array', 
            'addcoupon'          => 'nullable|array',
            'height'             => 'nullable|integer|min:0|max:10000',
            'length'             => 'nullable|integer|min:0|max:10000',
            'weight'             => 'nullable|integer|min:0|max:10000',
            'width'              => 'nullable|integer|min:0|max:10000',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'name.string' => 'Tên sản phẩm phải là một chuỗi văn bản.',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên sản phẩm bị trùng với sản phẩm khác.',
            'code.required' => 'Mã sản phẩm là bắt buộc.',
            'code.string' => 'Mã sản phẩm phải là một chuỗi văn bản.',
            'code.max' => 'Mã sản phẩm không được vượt quá 255 ký tự.',
            'code.unique' => 'Mã sản phẩm đã tồn tại trong hệ thống.',
            'category_id.required' => 'Danh mục sản phẩm là bắt buộc.',
            'category_id.exists' => 'Danh mục sản phẩm không hợp lệ.',
            'stock.required' => 'Số lượng không được để trống.',
            'stock.integer' => 'Số lượng phải là một số nguyên.',
            'stock.min' => 'Số lượng phải lớn hơn hoặc bằng 0.',
            'price_regular.required' => 'Nhập giá gốc.',
            'price_regular.numeric' => 'Giá gốc phải là một số.',
            'content.required' => 'Mô tả chi tiết sản phẩm là bắt buộc.',
            'content.string' => 'Mô tả chi tiết sản phẩm phải là một chuỗi văn bản.',
            'meta_title.max'  =>'Mô tả quá dài '
        ];
    }
}
