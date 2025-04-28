<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Categories</title>
    <link rel="stylesheet" href="assets/css/styles.css">

    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn:hover {
            opacity: 0.8;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .category-list {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }

        .category-item {
            padding: 20px;
            border: 1px solid #ddd;
            background: #f9f9f9;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .category-item h2 {
            margin: 0 0 10px;
            font-size: 22px;
            color: #2c3e50;
        }

        .category-item p {
            font-size: 16px;
            color: #555;
        }

        .actions {
            margin-top: 15px;
        }

        hr {
            border: none;
            height: 1px;
            background: #ddd;
            margin: 20px 0;
        }

        .no-categories {
            text-align: center;
            font-size: 18px;
            color: #888;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Display success and error messages -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['success_message']); ?>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['error_message']); ?>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <h1>Blog Categories</h1>
        <a href="/categories/create" class="btn btn-primary">Add New Category</a>

        <?php if (empty($categories)): ?>
            <p class="no-categories">No categories found.</p>
        <?php else: ?>
            <ul class="category-list">
                <?php foreach ($categories as $category): ?>
                    <li class="category-item">
                        <h2><?= htmlspecialchars($category['name']) ?></h2>
                        <p><strong>Slug:</strong> <?= htmlspecialchars($category['slug']) ?></p>
                        <p><?= htmlspecialchars($category['description']) ?></p>
                        <div class="actions">
                            <a href="/categories/edit?id=<?= $category['id'] ?>" class="btn btn-secondary">Edit</a>
                            <a href="/categories/delete?id=<?= $category['id'] ?>"
                                class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                        </div>
                    </li>
                    <hr>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</body>

</html>