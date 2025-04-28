<?php

namespace App\Controllers;


use App\Models\Post;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class PostController
{
    private $postModel;

    public function __construct(Post $postModel)
    {
        $this->postModel = $postModel;
    }

    public function index()
    {
        $posts = $this->postModel->getAllPosts();
        include __DIR__ . '/../Views/home.php';
    }

    public function create()
    {
        include __DIR__ . '/../Views/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_id = $_POST['user_id'];
            $category_id = $_POST['category_id'] ?? null;
            $title = htmlspecialchars($_POST['title']);
            $slug = htmlspecialchars($_POST['slug']);
            $content = htmlspecialchars($_POST['content']);
            $status = $_POST['status'] ?? 'draft';
            $published_at = $_POST['published_at'] ?? null;

            // Handle image upload
            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $maxFileSize = 5 * 1024 * 1024; // 5MB

                if (in_array($_FILES['image']['type'], $allowedTypes) && $_FILES['image']['size'] <= $maxFileSize) {
                    $imageFile = $_FILES['image']['tmp_name'];
                    $imageName = uniqid() . '-' . basename($_FILES['image']['name']);
                    $uploadDir = __DIR__ . '/../uploads/';

                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }

                    $uploadPath = $uploadDir . $imageName;

                    // Corrected usage of ImageManager
                    $manager = new ImageManager(new Driver());
                    $image = $manager->read($imageFile);
                    $image->resize(800, 600)->save($uploadPath);

                    $imagePath = 'uploads/' . $imageName;
                } else {
                    echo "Invalid file type or size.";
                    exit;
                }
            }

            if ($this->postModel->createPost($user_id, $category_id, $title, $slug, $content, $imagePath, $status, $published_at)) {
                header('Location: /');
                exit;
            } else {
                echo "Error creating post.";
            }
        }
    }

    public function edit($id)
    {
        $post = $this->postModel->find($id);
        if ($post) {
            include __DIR__ . '/../Views/edit.php';
        } else {
            echo "Post not found.";
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $category_id = $_POST['category_id'] ?? null;
            $title = htmlspecialchars($_POST['title']);
            $slug = htmlspecialchars($_POST['slug']);
            $content = htmlspecialchars($_POST['content']);
            $status = $_POST['status'] ?? 'draft';
            $published_at = $_POST['published_at'] ?? null;

            $post = $this->postModel->find($id);

            // Handle new image upload (if provided)
            $imagePath = $post['image'];
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $imageFile = $_FILES['image']['tmp_name'];
                $imageName = uniqid() . '-' . basename($_FILES['image']['name']);
                $uploadDir = __DIR__ . '/../uploads/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $uploadPath = $uploadDir . $imageName;

                // Process and save the image
                $manager = new ImageManager(new Driver());
                $manager->read($imageFile)->resize(800, 600)->save($uploadPath);

                // Delete old image if exists
                if (!empty($post['image']) && file_exists(__DIR__ . '/../' . $post['image'])) {
                    unlink(__DIR__ . '/../' . $post['image']);
                }

                $imagePath = 'uploads/' . $imageName;
            }

            if ($this->postModel->updatePost($id, $category_id, $title, $slug, $content, $imagePath, $status, $published_at)) {
                header('Location: /');
                exit;
            } else {
                echo "Error updating post.";
            }
        }
    }

    public function delete($id)
    {
        if ($this->postModel->deletePost($id)) {
            header('Location: /');
            exit;
        } else {
            echo "Error deleting post.";
        }
    }
}
