<?php
require 'config.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $stmt = $pdo->prepare("UPDATE posts SET title=?, content=? WHERE id=?");
    $stmt->execute([$title, $content, $id]);
    header('Location: index.php');
    exit;
}
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id=?");
$stmt->execute([$id]);
$post = $stmt->fetch();
?>
<!DOCTYPE html>
<html>
<head><title>Edit Post</title></head>
<body>
<h1>Edit Post</h1>
<form method="POST">
    <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required><br><br>
    <textarea name="content" rows="5" cols="40" required><?= htmlspecialchars($post['content']) ?></textarea><br><br>
    <button type="submit">Update Post</button>
</form>
<a href="index.php">Back</a>
</body>
</html>