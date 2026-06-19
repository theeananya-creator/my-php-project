<?php
require 'config.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
$posts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head><title>Blog Posts</title></head>
<body>
<h1>Blog Posts</h1>
<a href="create.php">Add New Post</a> | 
<a href="logout.php">Logout</a>
<hr>
<?php foreach ($posts as $post): ?>
    <h2><?= htmlspecialchars($post['title']) ?></h2>
    <p><?= htmlspecialchars($post['content']) ?></p>
    <small><?= $post['created_at'] ?></small><br>
    <a href="edit.php?id=<?= $post['id'] ?>">Edit</a> | 
    <a href="delete.php?id=<?= $post['id'] ?>" 
       onclick="return confirm('Delete this post?')">Delete</a>
    <hr>
<?php endforeach; ?>
</body>
</html>