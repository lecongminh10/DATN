<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class PaymentGatewayRequest extends FormRequest
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
            'api_key' => 'nullable|max:255',
            'secret_key' => 'nullable|max:255',
            'gateway_type' => 'required|string|max:255',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Tên phương thức không được để trống',
            'name.max' => 'Tên phương thức thanh toán không được vượt quá 255 ký tự',
            'api_key.max' => 'Key API không được vượt quá 255 ký tự',
            'secret_key.max' => 'Key bí mật không được vượt quá 255 ký tự',
            'gateway_type.required' => 'Loại phương không được để trống',
            'gateway_type.max' => 'Loại phương thức thanh toán không được vượt quá 255 ký tự',
        ];
    }
}
