<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarrierRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'api_url' => 'nullable|max:255',
            'api_token' => 'nullable|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'is_active' => 'required|in:active,inactive',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Tên nhà vận chuyển không được để trống.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
            'phone.max' => 'Số điện thoại không được vượt quá 15 ký tự.',
            'phone.required' => 'Số điện thoại không được để trống',
            'email.email' => 'Email không hợp lệ.',
            'email.required' => 'Email không được để trống.',
        ];
    }
}
