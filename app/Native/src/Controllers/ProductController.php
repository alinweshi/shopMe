<?php

namespace App\Controllers;

use Exception;
use App\Models\Product;
use Intervention\Image\Image;
use App\Services\UploadService;

use App\Services\ProductService;
use Intervention\Image\ImageManager;
use App\Validations\CreateProductValidation;
use App\Interfaces\ProductRepositoryInterface;
use Intervention\Image\Drivers\Imagick\Driver;

class ProductController
{
    private $productRepository;
    private $productService;
    private $uploadService;
    private $createProductValidation;

    public function __construct(ProductRepositoryInterface $productRepository, ProductService $productService, UploadService $uploadService, CreateProductValidation $createProductValidation)
    {
        $this->productRepository = $productRepository;
        $this->uploadService = $uploadService;

        $this->productService = $productService;
        $this->createProductValidation = $createProductValidation;
    }

    public function getAllProducts()
    {
        $products = $this->productRepository->getAll();
        // echo "<pre>";
        // var_dump($products);
        include __DIR__ . '/../Views/Product/index.php';
    }

    public function showProduct($id)
    {
        return $this->productRepository->getById($id);
    }

    public function createProduct()
    {
        include __DIR__ . '/../Views/Product/create.php';
    }
    // public function test_input($data)
    // {
    //     $data = trim($data);
    //     $data = stripslashes($data);
    //     $data = htmlspecialchars($data);
    //     return $data;
    // }
    public function storeProduct()
    {
        session_start();

        try {
            $data = $_POST;
            // Validate input data
            // $errors = $this->createProductValidation->validate($data);
            // if (!empty($errors)) {
            //     throw new Exception(json_encode($errors));
            // }
            echo "<pre>";
            var_dump($_POST);
            die();
            $file = $_FILES['image'];
            $this->createProductValidation->validate($data);
            // echo "<pre>";
            // var_dump($_POST);
            // die();
            // $data = array_merge($_POST, ['image' => $_FILES['image']]);
            $data['image'] = $this->uploadService->upload($file);
            // echo "<pre>";
            // var_dump($data);
            // die();


            $productId = $this->productService->createProduct($data);
            // echo "<pre>";
            // var_dump($productId);
            // die();
            $_SESSION['success-message'] = 'Product created successfully';
            $_SESSION['product_id'] = $productId;

            header('Location: /products');
        } catch (Exception $e) {
            $_SESSION['errors'] = json_decode($e->getMessage(), true);
            header('Location: /products/create');
        }
    }


    private function handleImageUpload(array $image): ?string
    {
        if ($image['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $uploadDir = __DIR__ . '/../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $imageName = uniqid() . '-' . basename($image['name']);
        $uploadPath = $uploadDir . $imageName;

        if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
            return 'uploads/' . $imageName;
        }

        return null;
    }






    public function editProduct($id)
    {
        return $this->productRepository->getById($id);
    }

    public function updateProduct($id)
    {
        // Validate and update the product
        $data = $_POST; // Validate and sanitize input
        return $this->productRepository->update($id, $data);
    }

    public function deleteProduct($id)
    {
        $this->productRepository->delete($id);
        $_SESSION['success-message'] = 'Successfully deleted';
        header('Location: /products');
        die();
    }

    public function searchProduct($query)
    {
        // Implement product search logic
    }
}
