<?php
require 'config.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // Validation
    if (empty($title)) {
        $errors[] = "Title is required!";
    } elseif (strlen($title) > 255) {
        $errors[] = "Title must be less than 255 characters!";
    }
    if (empty($content)) {
        $errors[] = "Content is required!";
    } elseif (strlen($content) < 10) {
        $errors[] = "Content must be at least 10 characters!";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
        $stmt->execute([$title, $content]);
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="mb-4">✏️ Add New Post</h2>
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control"
                                   value="<?= htmlspecialchars($title ?? '') ?>" maxlength="255" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Content</label>
                            <textarea name="content" class="form-control" rows="6" required><?= htmlspecialchars($content ?? '') ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Create Post</button>
                        <a href="index.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>