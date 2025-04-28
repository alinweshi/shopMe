<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Blog</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        /* assets/css/styles.css */

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #444;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            text-decoration: none;
            background: #3498db;
            color: #fff;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background: #2980b9;
        }

        .btn-danger {
            background: #e74c3c;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        .post {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            background: #fafafa;
            border-radius: 5px;
        }

        .post h2 {
            margin: 0 0 10px;
            font-size: 24px;
            color: #2c3e50;
        }

        .post p {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
        }

        small {
            display: block;
            margin-top: 10px;
            font-size: 14px;
            color: #888;
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
    </style>
</head>

<body>
    <div class="container">
        <h1>Blog Posts</h1>
        <a href="/create" class="btn">Create New Post</a>

        <?php if (empty($posts)): ?>
            <p>No posts found.</p>
        <?php else: ?>
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <h2><?= htmlspecialchars($post['title']) ?></h2>
                    <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                    <small>
                        Published on: <?= date('F j, Y, g:i a', strtotime($post['created_at'])) ?>
                    </small>
                    <div class="actions">
                        <a href="/edit?id=<?= $post['id'] ?>" class="btn">Edit</a>
                        <a href="/delete?id=<?= $post['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
                    </div>
                </div>
                <hr>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>

</html>