<?php

namespace App\Models;

use App\Database\Connection;
use PDOException;

class Post
{
    public $id;
    public $user_id;
    public $category_id;
    public $title;
    public $slug;
    public $content;
    public $image;
    public $status;
    public $published_at;
    public $created_at;
    public $updated_at;

    private $connection;

    public function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    public function getAllPosts()
    {
        try {
            $stmt = $this->connection->query("SELECT * FROM posts");
            return $stmt->fetchAll(\PDO::FETCH_CLASS, self::class);
        } catch (PDOException $e) {
            die("Error fetching posts: " . $e->getMessage());
        }
    }

    public function find($id)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM posts WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetchObject(self::class);
        } catch (PDOException $e) {
            die("Error finding post: " . $e->getMessage());
        }
    }

    public function createPost($user_id, $category_id, $title, $slug, $content, $image = null, $status = 'draft', $published_at = null)
    {
        try {
            $stmt = $this->connection->prepare("
                INSERT INTO posts (
                    user_id, category_id, title, slug, content, image, status, published_at, created_at, updated_at
                ) VALUES (
                    :user_id, :category_id, :title, :slug, :content, :image, :status, :published_at, :created_at, :updated_at
                )
            ");

            $created_at = date('Y-m-d H:i:s');
            $updated_at = $created_at;

            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':slug', $slug);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':image', $image);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':published_at', $published_at);
            $stmt->bindParam(':created_at', $created_at);
            $stmt->bindParam(':updated_at', $updated_at);

            return $stmt->execute();
        } catch (PDOException $e) {
            die("Error creating post: " . $e->getMessage());
        }
    }

    public function updatePost($id, $category_id, $title, $slug, $content, $image = null, $status = 'draft', $published_at = null)
    {
        try {
            $stmt = $this->connection->prepare("
                UPDATE posts SET
                    category_id = :category_id,
                    title = :title,
                    slug = :slug,
                    content = :content,
                    image = :image,
                    status = :status,
                    published_at = :published_at,
                    updated_at = :updated_at
                WHERE id = :id
            ");

            $updated_at = date('Y-m-d H:i:s');

            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':slug', $slug);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':image', $image);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':published_at', $published_at);
            $stmt->bindParam(':updated_at', $updated_at);
            $stmt->bindParam(':id', $id);

            return $stmt->execute();
        } catch (PDOException $e) {
            die("Error updating post: " . $e->getMessage());
        }
    }

    public function deletePost($id)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM posts WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            die("Error deleting post: " . $e->getMessage());
        }
    }
}
