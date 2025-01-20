<?php

namespace App\Http\Requests;

use App\Http\Requests\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class AddNewAddressRequest extends ApiRequest
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
            "line1" => "required",
            "city" => "required|string",
            "state" => "required|string",
            "country" => "required|string",
            "postal_code" => "required|string"
        ];
    }
}
