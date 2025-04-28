<?php
session_start(); // Start the session here

use App\Models\Post;
use App\Models\Product;
use App\Models\Category;
use App\Services\UploadService;
use App\Services\ProductService;
use App\Controllers\HomeController;
use App\Controllers\PostController;
use App\Controllers\ProductController;
use App\Controllers\CategoryController;
use App\Controllers\UserAuthController;
use App\Repositories\ProductRepository;
use App\Validations\CreateProductValidation;

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$queryParams = $_GET;

// Instantiate controllers
$postController = new PostController(new Post);
$authController = new UserAuthController();
$homeController = new HomeController();
$categoryController = new CategoryController(new Category);
$productRepository = new ProductRepository();
$createProductValidation = new CreateProductValidation();
$uploadService = new UploadService();
$createProductValidation = new CreateProductValidation();
$productService = new ProductService($productRepository, $createProductValidation, $uploadService);
$productController = new ProductController($productRepository, $productService, $uploadService, $createProductValidation);

// Route based on the request URI
switch (true) {
        // PostController Routes
    case $requestUri === '/create':
        $postController->create();
        break;
    case $requestUri === '/store':
        $postController->store();
        break;
    case $requestUri === '/edit':
        $id = $queryParams['id'] ?? null;
        $postController->edit($id);
        break;
    case $requestUri === '/update':
        $postController->update();
        break;
    case $requestUri === '/delete':
        $id = $queryParams['id'] ?? null;
        $postController->delete($id);
        break;
    case $requestUri === '/':
        $postController->index();
        break;

        // UserAuthController Routes
    case $requestUri === '/login':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $authController->showLoginForm();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->login();
        }
        break;

    case $requestUri === '/logout':
        $authController->logout();
        break;

    case $requestUri === '/register':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $authController->showRegisterForm();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->register();
        }
        break;

    case $requestUri === '/home':
        $homeController->index();
        break;

        // CategoryController Routes
    case $requestUri === '/categories':
        $categoryController->index();
        break;
    case $requestUri === '/categories/create':
        $categoryController->create();
        break;
    case $requestUri === '/categories/store':
        $categoryController->store();
        break;
    case preg_match('/^\/categories\/edit\/\d+$/', $requestUri):
        $id = explode('/', $requestUri)[3];
        $categoryController->edit($id);
        break;
    case $requestUri === '/categories/update':
        $categoryController->update();
        break;
    case preg_match('/^\/categories\/delete\/\d+$/', $requestUri):
        $id = explode('/', $requestUri)[3];
        $categoryController->delete($id);
        break;

        // ProductController Routes
    case $requestUri === '/products':
        $productController->getAllProducts();
        break;
    case $requestUri === '/products/create':
        $productController->createProduct();
        break;
    case $requestUri === '/products/store':
        $productController->storeProduct();
        break;
    case preg_match('/^\/products\/edit\/\d+$/', $requestUri):
        $id = explode('/', $requestUri)[3];
        $productController->editProduct($id);
        break;
    case preg_match('/^\/products\/update\/\d+$/', $requestUri):
        $id = explode('/', $requestUri)[3];
        $productController->updateProduct($id);
        break;
        // case $requestUri === '/products/update':
        //     $productController->updateProduct();
        //     break;
    case preg_match('/^\/products\/delete\/\d+$/', $requestUri):
        $id = explode('/', $requestUri)[3];
        $productController->deleteProduct($id);
        break;

        // Admin routes

    default:
        http_response_code(404);
        echo "404 Not Found";
        break;
}
