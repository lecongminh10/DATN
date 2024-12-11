<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules()
    {
        $id = $this->route('id'); // Lấy ID từ route
        if (isset($id)) {
            return [
                'applies_to' => 'required|string',
                'dynamic_value' => [
                    'required_if:applies_to,category,product,user',
                    'nullable',
                ],
                'code' => 'required|string|unique:coupons,code,' . $id,
                'description' => 'nullable|string',
                'discount_type' => 'required|in:percentage,fixed_amount',
                'discount_value' => 'required|numeric|min:0',
                'max_discount_amount' => 'nullable|numeric|min:0',
                'min_order_value' => 'nullable|numeric|min:0',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'usage_limit' => 'nullable|integer|min:0',
                'per_user_limit' => 'nullable|integer|min:0',
                'is_active' => 'required|in:0,1',
                'is_stackable' => 'required|in:0,1',
                'eligible_users_only' => 'required|in:0,1',
                'created_by' => 'exists:users,id',
            ];
        }
        return [
            'applies_to' => 'required|string',
            'dynamic_value' => [
                'required_if:applies_to,category,product,user',
                'nullable',
            ],
            'code' => 'required|string|unique:coupons,code',
            'description' => 'nullable|string',
            'discount_value' => 'required|numeric|min:0.01',
            'discount_type'  => 'required|in:percentage,fixed_amount',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'min_order_value' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'usage_limit' => 'nullable|integer|min:0',
            'per_user_limit' => 'nullable|integer|min:0',
            'is_active' => 'required|in:0,1',
            'is_stackable' => 'required|in:0,1',
            'eligible_users_only' => 'required|in:0,1',
            'created_by' => 'exists:users,id',
        ];
    }


    public function messages()
    {
        return [
            'applies_to.required'               => 'Phạm vi áp dụng là bắt buộc.',
            'dynamic_value.required_if'         => 'Trường dynamic value là bắt buộc khi áp dụng cho danh mục, sản phẩm hoặc người dùng.',
            'code.required'                     => 'Mã giảm giá là bắt buộc.',
            'code.unique'                       => 'Mã giảm giá đã tồn tại.',
            'description.string'                => 'Mô tả phải là chuỗi ký tự.',
            'discount_type.required'            => 'Loại giảm giá là bắt buộc.',
            'discount_value.required'           => 'Giá trị giảm giá là bắt buộc.',
            'discount_value.numeric'            => 'Giá trị giảm giá phải là số.',
            'max_discount_amount.numeric'       => 'Giảm giá tối đa phải là số.',
            'min_order_value.numeric'           => 'Giá trị đơn hàng tối thiểu phải là số.',
            'start_date.date'                   => 'Thời gian bắt đầu phải là ngày hợp lệ.',
            'end_date.date'                     => 'Thời gian kết thúc phải là ngày hợp lệ.',
            'end_date.after_or_equal'           => 'Thời gian kết thúc phải sau hoặc bằng thời gian bắt đầu.',
            'usage_limit.integer'               => 'Số lần sử dụng phải là số nguyên.',
            'per_user_limit.integer'            => 'Số lần sử dụng tối đa mỗi người dùng phải là số nguyên.',
            'is_active.required'                => 'Trạng thái hoạt động là bắt buộc.',
            'is_active.in'                      => 'Trạng thái hoạt động không hợp lệ.',
            'is_stackable.required'             => 'Trạng thái dùng chung là bắt buộc.',
            'is_stackable.in'                   => 'Trạng thái dùng chung không hợp lệ.',
            'eligible_users_only.required'      => 'Trạng thái dành riêng là bắt buộc.',
            'eligible_users_only.in'            => 'Trạng thái dành riêng không hợp lệ.',
            'created_by.exists'                 => 'Người tạo không tồn tại trong hệ thống.',
        ];
    }
}
