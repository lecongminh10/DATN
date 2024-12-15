<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'username' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'date_of_birth' => 'required|date',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ];
    }


    public function messages()
    {
        return [
            'username.required' => 'Tên người dùng không được để trống.',
            'username.string' => 'Tên người dùng phải là một chuỗi ký tự.',
            'username.max' => 'Tên người dùng không được vượt quá 255 ký tự.',
            
            'phone_number.required' => 'Số điện thoại không được để trống.',
            'phone_number.string' => 'Số điện thoại phải là một chuỗi ký tự.',
            'phone_number.max' => 'Số điện thoại không được vượt quá 15 ký tự.',
            
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',
            
            'date_of_birth.required' => 'Ngày sinh không được để trống.',
            'date_of_birth.date' => 'Ngày sinh phải là một ngày hợp lệ.',
            
            'profile_picture.nullable' => 'Ảnh đại diện là tùy chọn.',
            'profile_picture.image' => 'Ảnh đại diện phải là một hình ảnh.',
            'profile_picture.mimes' => 'Ảnh đại diện phải có định dạng jpg, jpeg hoặc png.',
            'profile_picture.max' => 'Ảnh đại diện không được vượt quá 2048 KB.'
        ];
    }
}
