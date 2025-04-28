<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <link rel="stylesheet" href="/assets/css/style.css"> <!-- Add your CSS file here -->
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Container */
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Headings */
        h1 {
            text-align: center;
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }

        /* Form Styling */
        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        textarea:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        /* Button Styles */
        .btn {
            display: inline-block;
            padding: 12px 20px;
            font-size: 16px;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: #fff;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        /* Alerts */
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 16px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                width: 90%;
                margin: 20px auto;
                padding: 20px;
            }

            h1 {
                font-size: 24px;
            }

            input[type="text"],
            textarea {
                font-size: 14px;
            }

            .btn {
                padding: 10px 16px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Edit Category</h1>

        <!-- Display success message -->
        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>

        <!-- Display validation errors -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="/categories/update" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($category['id']); ?>">

            <div class="form-group">
                <label for="name">Category Name:</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($category['name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="slug">Slug:</label>
                <input type="text" id="slug" name="slug" value="<?= htmlspecialchars($category['slug']); ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4"><?= htmlspecialchars($category['description']); ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Category</button>
            <a href="/categories" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script>
        // Simple client-side validation
        document.querySelector('form').addEventListener('submit', function(e) {
            let name = document.getElementById('name').value.trim();
            let slug = document.getElementById('slug').value.trim();

            if (!name || !slug) {
                e.preventDefault();
                alert('Name and Slug fields are required.');
            }
        });
    </script>
</body>

</html>