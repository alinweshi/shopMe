<?php

namespace App\Models;

use PDO;
use App\Database\Connection;

class Category
{
    public $id;
    public $name;
    public $slug;
    public $description;
    public $created_at;
    public $updated_at;
    public $deleted_at;
    public $parent_id;
    private $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    public function all()
    {
        $stmt = $this->db->prepare("SELECT * FROM categories");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    public function createCategory($name, $slug, $description, $parent_id)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO categories (
                name, slug, description, parent_id, created_at, updated_at
            ) VALUES (
                :name, :slug, :description, :parent_id, :created_at, :updated_at
            )"
        );

        $created_at = date('Y-m-d H:i:s');
        $updated_at = $created_at;

        $stmt->bindParam('name', $name);
        $stmt->bindParam('slug', $slug);
        $stmt->bindParam('description', $description);
        $stmt->bindParam('parent_id', $parent_id);
        $stmt->bindParam('created_at', $created_at);
        $stmt->bindParam('updated_at', $updated_at);

        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function updateCategory($id, $name, $slug, $description, $parent_id)
    {
        $stmt = $this->db->prepare(
            "UPDATE categories SET
                name = :name,
                slug = :slug,
                description = :description,
                parent_id = :parent_id,
                updated_at = :updated_at
            WHERE id = :id"
        );

        $updated_at = date('Y-m-d H:i:s');

        $stmt->bindParam('id', $id);
        $stmt->bindParam('name', $name);
        $stmt->bindParam('slug', $slug);
        $stmt->bindParam('description', $description);
        $stmt->bindParam('parent_id', $parent_id);
        $stmt->bindParam('updated_at', $updated_at);

        $stmt->execute();
    }
    public function deleteCategory($id)
    {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $this->id = null;
    }
}
