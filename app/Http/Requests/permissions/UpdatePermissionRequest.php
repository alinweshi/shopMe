<?php

namespace App\Http\Requests\permissions;

use App\Http\Requests\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionRequest extends ApiRequest
{
    public function authorize(): bool
    {
        return true; // Change this if needed for authorization
    }

    public function rules(): array
    {
        return [
            'name' => 'required|unique:permissions,name,' . $this->permission->id . '|max:255',
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
