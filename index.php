<?php
require 'config.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Search
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Pagination
$posts_per_page = 3;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $posts_per_page;

// Count total posts
if ($search) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM posts WHERE title LIKE ? OR content LIKE ?");
    $stmt->execute(["%$search%", "%$search%"]);
} else {
    $stmt = $pdo->query("SELECT COUNT(*) FROM posts");
}
$total_posts = $stmt->fetchColumn();
$total_pages = ceil($total_posts / $posts_per_page);

// Fetch posts
if ($search) {
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE title LIKE ? OR content LIKE ? ORDER BY created_at DESC LIMIT ? OFFSET ?");
    $stmt->bindValue(1, "%$search%", PDO::PARAM_STR);
    $stmt->bindValue(2, "%$search%", PDO::PARAM_STR);
    $stmt->bindValue(3, $posts_per_page, PDO::PARAM_INT);
    $stmt->bindValue(4, $offset, PDO::PARAM_INT);
    $stmt->execute();
} else {
    $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY created_at DESC LIMIT ? OFFSET ?");
    $stmt->bindValue(1, $posts_per_page, PDO::PARAM_INT);
    $stmt->bindValue(2, $offset, PDO::PARAM_INT);
    $stmt->execute();
}
$posts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Blog Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .post-card { transition: transform 0.2s; }
        .post-card:hover { transform: translateY(-5px); box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .navbar-brand { font-weight: bold; font-size: 1.5rem; }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <span class="navbar-brand">📝 My Blog</span>
        <div>
            <span class="text-white me-3">
                Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!
                <span class="badge bg-<?= $_SESSION['role'] === 'admin' ? 'danger' : 'success' ?>">
                    <?= $_SESSION['role'] ?>
                </span>
            </span>
            <a href="dashboard.php" class="btn btn-outline-light btn-sm me-2">📊 Dashboard</a>
            <a href="create.php" class="btn btn-success btn-sm me-2">+ New Post</a>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <!-- Search Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control"
                       placeholder="Search posts by title or content..."
                       value="<?= htmlspecialchars($search) ?>">
                <button type="submit" class="btn btn-primary">Search</button>
                <?php if ($search): ?>
                    <a href="index.php" class="btn btn-secondary">Clear</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Search Results Info -->
    <?php if ($search): ?>
        <p class="text-muted">Showing results for: <strong><?= htmlspecialchars($search) ?></strong> (<?= $total_posts ?> found)</p>
    <?php endif; ?>

    <!-- Posts -->
    <?php if (empty($posts)): ?>
        <div class="alert alert-info">No posts found. <a href="create.php">Create your first post!</a></div>
    <?php endif; ?>

    <div class="row">
        <?php foreach ($posts as $post): ?>
        <div class="col-md-6 mb-4">
            <div class="card post-card h-100">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($post['title']) ?></h5>
                    <p class="card-text text-muted"><?= nl2br(htmlspecialchars(substr($post['content'], 0, 150))) ?>...</p>
                    <small class="text-muted">📅 <?= $post['created_at'] ?></small>
                </div>
                <div class="card-footer">
                    <a href="edit.php?id=<?= $post['id'] ?>" class="btn btn-warning btn-sm">✏️ Edit</a>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <a href="delete.php?id=<?= $post['id'] ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Are you sure you want to delete this post?')">🗑️ Delete</a>
                    <?php else: ?>
                        <span class="badge bg-secondary">Only admins can delete</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>">Previous</a>
            </li>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>
            <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>">Next</a>
            </li>
        </ul>
    </nav>
    <?php endif; ?>
</div>
</body>
</html>