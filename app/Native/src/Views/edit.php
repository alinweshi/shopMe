<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link rel="stylesheet" href="../../../assets/css/styles.css">
</head>

<body>
    <h1>Edit Post</h1>
    <?php if ($post): ?>
        <form action="/update" method="POST">
            <input type="hidden" name="id" value="<?= $post->id ?>">

            <label for="category_id">Category ID (optional):</label>
            <input type="number" name="category_id" id="category_id" value="<?= $post->category_id ?>">

            <label for="title">Title:</label>
            <input type="text" name="title" id="title" value="<?= $post->title ?>" required>

            <label for="slug">Slug:</label>
            <input type="text" name="slug" id="slug" value="<?= $post->slug ?>" required>

            <label for="content">Content:</label>
            <textarea name="content" id="content" required><?= $post->content ?></textarea>

            <label for="image">Image (optional):</label>
            <input type="text" name="image" id="image" value="<?= $post->image ?>">

            <label for="status">Status:</label>
            <div class="select-wrapper">
                <select name="status" id="status">
                    <option value="draft" <?= $post->status === 'draft' ? 'selected' : '' ?>>Draft</option>
                    <option value="published" <?= $post->status === 'published' ? 'selected' : '' ?>>Published</option>
                </select>
            </div>

            <label for="published_at">Published At (optional):</label>
            <input type="datetime-local" name="published_at" id="published_at" value="<?= $post->published_at ?>">

            <button type="submit">Update Post</button>
        </form>
    <?php else: ?>
        <p>Post not found.</p>
    <?php endif; ?>
</body>

</html>