<?php
require 'config.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $stmt = $pdo->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
    $stmt->execute([$title, $content]);
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Add Post</title></head>
<body>
<h1>Add New Post</h1>
<form method="POST">
    <input type="text" name="title" placeholder="Title" required><br><br>
    <textarea name="content" placeholder="Content" rows="5" cols="40" required></textarea><br><br>
    <button type="submit">Create Post</button>
</form>
<a href="index.php">Back</a>
</body>
</html>