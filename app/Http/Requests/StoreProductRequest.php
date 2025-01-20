<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // You can add authorization logic if needed
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'brand' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'final_price' => 'nullable|numeric|min:0|lt:price', // Ensure final_price is less than price
            'discount_type' => 'nullable|in:percentage,fixed', // Validate discount type
            'discount' => 'required_if:discount_type,percentage,fixed|numeric|min:0', // Validate discount if type is selected
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    /**
     * Get custom error messages for the validator.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'The product name is required.',
            'slug.required' => 'The slug is required.',
            'slug.unique' => 'The slug must be unique.',
            'category_id.required' => 'The category is required.',
            'category_id.exists' => 'The selected category is invalid.',
            'price.required' => 'The price is required.',
            'price.numeric' => 'The price must be a number.',
            'price.min' => 'The price must be at least 0.',
            'final_price.lt' => 'The final price must be less than the original price.',
            'final_price.min' => 'The final price must be at least 0.',
            'discount_type.in' => 'The discount type must be either "percentage" or "fixed".',
            'discount.required_if' => 'The discount value is required when a discount type is selected.',
            'discount.numeric' => 'The discount must be a valid number.',
            'discount.min' => 'The discount must be at least 0.',
            'image.mimes' => 'The image must be a type of jpeg, png, jpg, gif, or svg.',
            'image.max' => 'The image size must not exceed 2MB.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        // Return a custom JSON response when validation fails
        throw new HttpResponseException(
            response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $errors,
            ], 422)
        );
    }
}
