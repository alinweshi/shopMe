<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>
    <link rel="stylesheet" href="/assets/css/createProduct.css">
</head>

<body>
    <?php
    session_start();

    // Display errors if any
    if (isset($_SESSION['errors'])) {
        echo '<div class="errors">';
        foreach ($_SESSION['errors'] as $field => $messages) {
            echo '<strong>' . htmlspecialchars($field) . ':</strong>';
            echo '<ul>';
            foreach ($messages as $message) {
                echo '<li>' . htmlspecialchars($message) . '</li>';
            }
            echo '</ul>';
        }
        echo '</div>';
        unset($_SESSION['errors']);
    }

    // Display success message if product is successfully created
    if (isset($_SESSION['success-message'])) {
        echo '<div class="success">' . htmlspecialchars($_SESSION['success-message']) . '</div>';
        unset($_SESSION['success-message']);
    }

    ?>

    <header>
        <h1>Create New Product</h1>
        <a href="/products">Back to Product List</a> <!-- Link to the product list -->
    </header>

    <section>
        <form action="/products/store" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" name="price" id="price" step="0.01" value="<?php echo htmlspecialchars($_POST['price'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="category_id">Category ID</label>
                <input type="number" name="category_id" id="category_id" value="<?php echo htmlspecialchars($_POST['category_id'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="4"><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label for="brand">Brand</label>
                <input type="text" name="brand" id="brand" value="<?php echo htmlspecialchars($_POST['brand'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="image">Product Image</label>
                <input type="file" name="image" id="image">
            </div>

            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" name="stock" id="stock" value="<?php echo htmlspecialchars($_POST['stock'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="discount">Discount</label>
                <input type="number" name="discount" id="discount" step="0.01" value="<?php echo htmlspecialchars($_POST['discount'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="discount_type">Discount Type</label>
                <select name="discount_type" id="discount_type">
                    <option value="percentage" <?php echo ($_POST['discount_type'] ?? '') === 'percentage' ? 'selected' : ''; ?>>Percentage</option>
                    <option value="flat" <?php echo ($_POST['discount_type'] ?? '') === 'flat' ? 'selected' : ''; ?>>Flat</option>
                </select>
            </div>

            <button type="submit">Create Product</button>
        </form>
    </section>
</body>

</html>