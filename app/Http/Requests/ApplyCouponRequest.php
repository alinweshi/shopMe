<?php

namespace App\Http\Requests;

use tr;

class ApplyCouponRequest extends ApiRequest
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
            'code' => "required|exists:coupons,code",
        ];
    }
    public function messages()
    {
        return [
            'code.required' => 'coupon is required',
            'code.exists' => 'coupon is not valid',
        ];
    }
}
