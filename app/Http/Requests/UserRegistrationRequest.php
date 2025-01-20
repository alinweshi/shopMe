<?php

namespace App\Http\Requests;

use App\Http\Requests\ApiRequest;

class UserRegistrationRequest extends ApiRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:8',
            "password_confirmation" => "required|same:password",
        ];
    }
    public function messages()
    {
        return [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email is not valid',
            'email.unique' => 'Email is already taken',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'password_confirmation.required' => 'Password confirmation is required',
        ];
    }
    // protected function failedValidation(Validator $validator)
    // {
    //     $errors = $validator->errors();

    //     // Return a custom JSON response when validation fails
    //     throw new HttpResponseException(
    //         response()->json([
    //             'status' => 'error',
    //             'message' => 'Validation failed.',
    //             'errors' => $errors,
    //         ], 422)
    //     );
    // }
}
