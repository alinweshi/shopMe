<?php

namespace App\Repositories\Products;

use PDO;
use App\Database\Connection;
use App\Interfaces\ProductRepositoryInterface;

abstract class AbstractProductRepository implements ProductRepositoryInterface
{
    private $db;
    private $table = 'products';

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (name, price, category_id, description, brand, image, stock, discount, discount_type) VALUES (:name, :price, :category_id, :description, :brand, :image, :stock, :discount, :discount_type)");
        $stmt->execute($data);
        return $this->db->lastInsertId();
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET name = :name, price = :price, category_id = :category_id, description = :description, brand = :brand, image = :image, stock = :stock, discount = :discount, discount_type = :discount_type WHERE id = :id");
        $stmt->execute(array_merge($data, ['id' => $id]));
        return $stmt->rowCount();
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount();
    }
}
