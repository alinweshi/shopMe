<?php

declare(strict_types=1);

namespace App\Models;

class Product
{
    public $id;
    public $name;
    public $price;
    public $slug;
    public $category_id;
    public $description;
    public $brand;
    public $image;
    public $stock;
    public $discount;
    public $discount_type;

    public function __construct($data = [])
    {
        $this->name = $this->test_input($data['name'] ?? '');
        $this->price = $data['price'];
        $this->category_id = isset($data['category_id']) ? $this->validateInt($data['category_id']) : null;
        $this->description = !empty($data['description']) ? $this->test_input($data['description']) : null;
        $this->brand = !empty($data['brand']) ? $this->test_input($data['brand']) : null;
        $this->image = !empty($data['image']) ? $this->test_input($data['image']) : null;
        $this->stock = isset($data['stock']) ? (is_numeric($data['stock']) ? (int)$data['stock'] : null) : null;
        $this->discount = isset($data['discount']) ? (is_numeric($data['discount']) ? $data['discount'] + 0 : null) : null;
        $this->discount_type = !empty($data['discount_type']) ? $this->test_input($data['discount_type']) : null;
        $this->slug = $this->generateSlug($this->name);
    }

    public function test_input($data)
    {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    public function generateSlug($name)
    {
        return strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $name));
    }

    private function validateInt($value)
    {
        return filter_var($value, FILTER_VALIDATE_INT) !== false ? (int) $value : null;
    }
}
