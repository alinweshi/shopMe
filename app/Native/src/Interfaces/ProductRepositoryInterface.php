<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function getById($id);
    public function getAll();
    public function create($product);
    public function update($id, $data);
    public function delete($id);  // Delete a product by its ID
}
