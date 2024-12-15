<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarrierRequest extends FormRequest
{
    /**
     * Xác định xem người dùng có được phép thực hiện yêu cầu này không.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Lấy các quy tắc xác thực áp dụng cho yêu cầu này.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $carrierId = $this->route('id'); // Lấy id từ route nếu có

        return [
            'name' => 'required|string|max:255|unique:carriers,name,' . $carrierId,
            'code' => 'required|string|max:255|unique:carriers,code,' . $carrierId,
            'api_url' => 'required|max:255|url',
            'api_token' => 'required|string|max:255',
            'phone' => 'required|string|max:15|unique:carriers,phone,' . $carrierId,
            'email' => 'required|email|max:255|unique:carriers,email,' . $carrierId,
            'is_active' => 'required|in:active,inactive',
        ];
    }

    /**
     * Lấy thông báo tùy chỉnh cho các quy tắc xác thực.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'name.required' => 'Tên nhà vận chuyển không được để trống.',
            'name.unique' => 'Tên nhà vận chuyển đã được sử dụng.',
            'code.required' => 'Mã vận chuyển không được để trống.',
            'code.unique' => 'Mã vận chuyển đã được sử dụng.',
            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.unique' => 'Số điện thoại đã được sử dụng.',
            'email.email' => 'Email không hợp lệ.',
            'email.required' => 'Email không được để trống.',
            'email.unique' => 'Email đã được sử dụng.',
            'api_url.url' => 'API URL không hợp lệ.',
            'api_url.required' => 'API URL không được để trống.',
            'api_token.required' => 'API Token không được để trống.',
        ];
    }
}
