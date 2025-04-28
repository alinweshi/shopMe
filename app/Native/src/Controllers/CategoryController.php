<?php

namespace App\Controllers;

use App\Models\Category;

class CategoryController
{
    public $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        $categories = $this->category->all();
        include __DIR__ . '/../Views/category.php';
    }

    public function create()
    {
        include __DIR__ . '/../Views/createCategory.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            session_start(); // Start session for flash messages

            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $slug = $_POST['slug'] ?? '';
            $parent_id = $_POST['parent_id'] ?? null;

            if (!empty($name) && !empty($description) && !empty($slug)) {
                try {
                    $this->category->createCategory($name, $slug, $description, $parent_id);

                    $_SESSION['success_message'] = "Category created successfully!";
                    header('Location: /categories');
                    exit;
                } catch (\PDOException $e) {
                    $_SESSION['error_message'] = "Error creating category: " . $e->getMessage();
                    header('Location: /categories/create');
                    exit;
                }
            } else {
                $_SESSION['error_message'] = "All fields are required.";
                header('Location: /categories/create');
                exit;
            }
        }
    }


    public function edit($id)
    {
        $categoryModel = new Category();
        $category = $categoryModel->find($id);

        if (!$category) {
            $_SESSION['error_message'] = "Category not found.";
            header('Location: /categories');
            exit;
        }

        include __DIR__ . '/../views/editCategory.php';
    }


    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/categories/update') {
            $id = $_POST['id'] ?? null;
            $name = trim($_POST['name']);
            $slug = trim($_POST['slug']);
            $description = trim($_POST['description']);
            $parent_id = $_POST['parent_id'] ?? null;

            $errors = [];

            if (empty($name)) {
                $errors[] = "Category name is required.";
            }
            if (empty($slug)) {
                $errors[] = "Slug is required.";
            }

            if ($errors) {
                $_SESSION['errors'] = $errors;
                header("Location: /categories/edit?id=$id");
                exit;
            }

            $categoryModel = new Category();
            $categoryModel->updateCategory($id, $name, $slug, $description, $parent_id);

            $_SESSION['success_message'] = "Category updated successfully!";
            header('Location: /categories');
            exit;
        } else {
            $_SESSION['error_message'] = "All fields are required.";
            header('Location: /categories/edit/{$id}');
            exit;
        }
    }
    public function delete($id)
    {
        $category = $this->category->find($id);
        if ($category) {
            try {
                $this->category->deleteCategory($id);
                $_SESSION["success_message"] = 'Category deleted successfully';
                header('Location: /categories');
                exit;
            } catch (\PDOException $e) {
                echo "Error deleting category: " . $e->getMessage();
            }
        } else {
            echo "Category not found.";
        }
    }
}
