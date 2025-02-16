<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends ApiRequest
{
    public function authorize(): bool
    {
        return true; // Change this to implement authorization logic if needed.
    }

    public function rules(): array
    {
        return [
            'name' => 'required|unique:roles,name|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The role name is required.',
            'name.unique' => 'This role name already exists.',
            'name.max' => 'The role name cannot exceed 255 characters.',
        ];
    }
}
