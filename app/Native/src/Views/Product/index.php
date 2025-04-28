<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="/assets/css/productIndex.css">
</head>

<body>
    <header>
        <h1>Product List</h1>
        <nav>
            <a href="/products/create">Add New Product</a>
        </nav>
    </header>

    <main>
        <section>
            <?php
            session_start();
            ?>
            <div class="message">
                <!-- <div class="errors"> -->
                <?php
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
                ?>
                <!-- </div> -->
                <!-- <div class="success"> -->
                <?php
                if (isset($_SESSION['success-message'])) {
                    echo '<div class="success">' . htmlspecialchars($_SESSION['success-message']) . '</div>';
                    unset($_SESSION['success-message']);
                }
                ?>
                <!-- </div> -->
            </div>
            <?php if (!empty($products)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Category ID</th>
                            <th>Description</th>
                            <th>Brand</th>
                            <th>Image</th>
                            <th>Stock</th>
                            <th>Discount</th>
                            <th>Discount Type</th>
                            <th>Slug</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td data-label="ID"><?php echo htmlspecialchars($product->id); ?></td>
                                <td data-label="Name"><?php echo htmlspecialchars($product->name); ?></td>
                                <td data-label="Price"><?php echo htmlspecialchars($product->price); ?></td>
                                <td data-label="Category ID"><?php echo htmlspecialchars($product->category_id); ?></td>
                                <td data-label="Description"><?php echo htmlspecialchars($product->description); ?></td>
                                <td data-label="Brand"><?php echo htmlspecialchars($product->brand); ?></td>
                                <td data-label="Image">
                                    <?php if ($product->image): ?>
                                        <img src="<?php echo htmlspecialchars($product->image); ?>" alt="Product Image" width="50">
                                    <?php else: ?>
                                        <span>No image</span>
                                    <?php endif; ?>
                                </td>
                                <td data-label="Stock"><?php echo htmlspecialchars($product->stock); ?></td>
                                <td data-label="Discount"><?php echo htmlspecialchars($product->discount); ?>%</td>
                                <td data-label="Discount Type"><?php echo htmlspecialchars($product->discount_type); ?></td>
                                <td data-label="Slug"><?php echo htmlspecialchars($product->slug); ?></td>
                                <td data-label="Actions">
                                    <a href="/products/edit/<?php echo htmlspecialchars($product->id); ?>">Edit</a>
                                    <a href="/products/delete/<?php echo htmlspecialchars($product->id); ?>" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No products found.</p>
            <?php endif; ?>
        </section>
    </main>
</body>

</html>