<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>

<body>

    <div class="container">
        <h1>Create a New Post</h1>
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
            unset($_SESSION['errors']); // Clear after displaying
        }

        if (isset($_SESSION['success-message'])) {
            echo '<div class="success">' . htmlspecialchars($_SESSION['success-message']) . '</div>';
            unset($_SESSION['success-message']); // Clear after displaying
        }

        ?>
        <form action="/store" method="POST" class="post-form">
            <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
            <input type="hidden" name="id" value="<?= $post['id'] ?>">

            <div class="form-group">
                <label for="user_id">User ID:</label>
                <input type="number" name="user_id" value="<?= $post['user_id'] ?>">
            </div>

            <div class="form-group">
                <label for="category_id">Category ID (optional):</label>
                <input type="number" name="category_id" id="category_id">
            </div>

            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" required>
            </div>

            <div class="form-group">
                <label for="slug">Slug:</label>
                <input type="text" name="slug" id="slug" required>
            </div>

            <div class="form-group">
                <label for="content">Content:</label>
                <textarea name="content" id="content" required></textarea>
            </div>

            <div class="form-group">
                <label for="image">Image (optional):</label>
                <input type="file" name="image" id="image">
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <select name="status" id="status">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>

            <div class="form-group">
                <label for="published_at">Published At (optional):</label>
                <input type="datetime-local" name="published_at" id="published_at">
            </div>

            <button type="submit" class="btn">Create Post</button>
        </form>
    </div>

    <script>
        document.getElementById('title').addEventListener('input', function() {
            const title = this.value;
            const slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
            document.getElementById('slug').value = slug;
        });
    </script>
</body>

</html>