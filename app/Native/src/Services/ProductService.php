<?php

namespace App\Services;

use Exception;
use Intervention\Image\ImageManager;
use App\Repositories\ProductRepository;
use App\Validations\CreateProductValidation;
use Intervention\Image\ImageManager as Image;
use Intervention\Image\Drivers\Imagick\Driver;

class ProductService
{
    private $productRepository;
    private $uploadService;

    private $validation;

    public function __construct(ProductRepository $productRepository, CreateProductValidation $validation, UploadService $uploadService)
    {
        $this->productRepository = $productRepository;
        $this->validation = $validation;
        $this->uploadService = $uploadService;
    }
    public function createProduct(array $data): int
    {
        // // Uncomment validation if necessary
        // // $errors = $this->validation->validate($data);

        // if (!empty($errors)) {
        //     throw new Exception(json_encode($errors));
        // }

        // $imagePath = $this->uploadService->upload($data['image']);

        // if ($imagePath) {
        //     $data['image'] = $imagePath;
        // } else {
        //     throw new Exception(json_encode(['image' => 'Failed to upload image.']));
        // }

        return $this->productRepository->create($data);
    }
}
