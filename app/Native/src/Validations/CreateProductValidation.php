<?php

namespace App\Validations;

use Exception;

class CreateProductValidation
{
    private $rules = [
        'name' => 'required|max:255',
        'price' => 'required|numeric|min:0',
        'category_id' => 'required|numeric',
        'description' => 'nullable|string',
        'brand' => 'nullable|string|max:100',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        'stock' => 'required|numeric|min:0',
        'discount' => 'nullable|numeric|min:0|max:100',
        'discount_type' => 'nullable|string|max:50',
    ];

    public function validate(array $data): array
    {
        $errors = [];

        foreach ($this->rules as $field => $rule) {
            $fieldRules = explode('|', $rule);

            foreach ($fieldRules as $fieldRule) {
                $value = $data[$field] ?? null;

                if ($field === 'image') {
                    continue;
                }

                // Check if the field is required and empty
                if ($fieldRule === 'required' && empty($value)) {
                    $errors[$field][] = "{$field} is required.";
                }

                // Check if the field must be numeric
                elseif ($fieldRule === 'numeric' && !is_numeric($value)) {
                    $errors[$field][] = "{$field} must be a valid number.";
                }

                // Check for minimum value
                elseif (strpos($fieldRule, 'min:') !== false) {
                    $minValue = (int) substr($fieldRule, 4);
                    if (is_numeric($value) && (float)$value < $minValue) {
                        $errors[$field][] = "{$field} must be at least {$minValue}.";
                    }
                }

                // Check for maximum value
                elseif (strpos($fieldRule, 'max:') !== false) {
                    $maxValue = (int) substr($fieldRule, 4);

                    // Handle numeric max checks
                    if (is_numeric($value) && (float)$value > $maxValue) {
                        $errors[$field][] = "{$field} must not exceed {$maxValue}.";
                    }

                    // Handle string length max checks
                    if (is_string($value) && strlen($value) > $maxValue) {
                        $errors[$field][] = "{$field} must not exceed {$maxValue} characters.";
                    }
                }
            }
        }

        return $errors;
    }
}
