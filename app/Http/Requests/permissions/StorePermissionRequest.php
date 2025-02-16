<?php

namespace App\Http\Requests\permissions;

use App\Http\Requests\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StorePermissionRequest extends ApiRequest
{
    public function authorize(): bool
    {
        return true; // Change this if you want to add authorization logic
    }

    public function rules(): array
    {
        return [
            'name' => 'required|array', // Validate that 'name' is an array
            'name.*' => 'required|string|max:255', // Validate each item in the array
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The permission name is required.',
            'name.unique' => 'This permission already exists.',
            'name.max' => 'The permission name cannot exceed 255 characters.',
        ];
    }
}
