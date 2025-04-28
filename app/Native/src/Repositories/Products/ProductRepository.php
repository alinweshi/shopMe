<?php

namespace App\Repositories;

use PDO;
use App\Database\Connection;
use App\Interfaces\ProductRepositoryInterface;
use App\Repositories\Products\AbstractProductRepository;

class ProductRepository extends AbstractProductRepository implements ProductRepositoryInterface
{
    private $db;
    private $table = 'products';

    public function __construct()
    {
        parent::__construct();
    }

    public function getAll()
    {
        return parent::getAll();
    }

    public function getById($id)
    {
        return parent::getById($id);  // Use parent method if you want to use the generic method from the parent class
        // $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        // $stmt->execute(['id' => $id]);
        // return $stmt->fetch();
    }

    public function create($data)
    {
        return parent::create($data);

        // $stmt = $this->db->prepare("INSERT INTO {$this->table} (name, price, category_id, description, brand, image, stock, discount, discount_type) VALUES (:name, :price, :category_id, :description, :brand, :image, :stock, :discount, :discount_type)");
        // $stmt->execute($data);
        // return $this->db->lastInsertId();
    }

    public function update($id, $data)
    {
        return parent::update($id, $data);
        // $stmt = $this->db->prepare("UPDATE {$this->table} SET name = :name, price = :price, category_id = :category_id, description = :description, brand = :brand, image = :image, stock = :stock, discount = :discount, discount_type = :discount_type WHERE id = :id");
        // $stmt->execute(array_merge($data, ['id' => $id]));
        // return $stmt->rowCount();
    }

    public function delete($id)
    {
        return parent::delete($id);
        // $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        // $stmt->execute(['id' => $id]);
        // return $stmt->rowCount();
    }
}
