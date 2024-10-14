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

        return [
            'applies_to' => 'required|string|max:20',
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
            // 'created_by' => 'exists:users,id', // Nếu cần kiểm tra người tạo
        ];
    }


    public function messages()
    {
        return [
            'applies_to.required'               => 'Phạm vi áp dụng là bắt buộc.',
            'code.required'                     => 'Mã giảm giá là bắt buộc.',
            'code.unique'                       => 'Mã giảm giá đã tồn tại.',
            'discount_type.required'            => 'Loại giảm giá là bắt buộc.',
            'discount_value.required'           => 'Giá trị giảm giá là bắt buộc.',
            'max_discount_amount.numeric'       => 'Giảm giá tối đa phải là số.',
            'min_order_value.numeric'           => 'Giá trị đơn hàng tối thiểu phải là số.',
            'end_date.after_or_equal'           => 'Thời gian kết thúc phải sau hoặc bằng thời gian bắt đầu.',
            'created_by.required'               => 'ID người tạo là bắt buộc.',
            'created_by.exists'                 => 'Người tạo không tồn tại trong hệ thống.',
        ];
    }
}
