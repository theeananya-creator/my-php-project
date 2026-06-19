<?php
require 'config.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get stats
$total_posts = $pdo->query("SELECT COUNT(*) FROM posts")->fetchColumn();
$total_users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$recent_posts = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

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
            <a href="index.php" class="btn btn-outline-light btn-sm me-2">📋 Posts</a>
            <a href="create.php" class="btn btn-success btn-sm me-2">+ New Post</a>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <h2 class="mb-4">📊 Dashboard</h2>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary shadow">
                <div class="card-body text-center">
                    <h1><?= $total_posts ?></h1>
                    <p class="mb-0">Total Posts</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success shadow">
                <div class="card-body text-center">
                    <h1><?= $total_users ?></h1>
                    <p class="mb-0">Total Users</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info shadow">
                <div class="card-body text-center">
                    <h1><?= $_SESSION['role'] === 'admin' ? '👑' : '✏️' ?></h1>
                    <p class="mb-0">Your Role: <?= $_SESSION['role'] ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Posts -->
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">🕒 Recent Posts</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_posts as $post): ?>
                    <tr>
                        <td><?= $post['id'] ?></td>
                        <td><?= htmlspecialchars($post['title']) ?></td>
                        <td><?= $post['created_at'] ?></td>
                        <td>
                            <a href="edit.php?id=<?= $post['id'] ?>" class="btn btn-warning btn-sm">✏️ Edit</a>
                            <?php if ($_SESSION['role'] === 'admin'): ?>
                                <a href="delete.php?id=<?= $post['id'] ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Delete this post?')">🗑️</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>