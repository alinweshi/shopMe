<?php

namespace App\Http\Requests;

class UserLoginRequest extends ApiRequest
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
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            "password" => "required|min:6",
        ];
    }
    public function messages()
    {
        return [
            "email.required" => "Email is required",
            "email.email" => "Email is not valid",
            "email.exists" => "Email is not exists",
            "password.required" => "Password is required",
        ];
    }
}
