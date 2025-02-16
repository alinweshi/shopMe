<?php

namespace App\Http\Requests\Jwt\Admins;

use App\Http\Requests\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class AdminRegisterRequest extends ApiRequest
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
            ''
        ];
    }
}
