<?php

namespace App\Http\Requests\Jwt\Admins;

use App\Http\Requests\ApiRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class AdminLoginRequest extends ApiRequest
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
            'email' => 'required|email|exists:admins,email',
            // 'password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            //     'password' => Password::min(8)
            //         ->letters()
            //         ->mixedCase()
            //         ->numbers()
            //         ->symbols()
            //         ->uncompromised()
            //
            'password' => Password::min(8)
        ];
    }
}
