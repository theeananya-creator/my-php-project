<?php
require 'config.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Only admin can delete
if ($_SESSION['role'] !== 'admin') {
    die('<div class="container mt-5"><div class="alert alert-danger">Access denied! Only admins can delete posts. <a href="index.php">Go back</a></div></div>');
}

$id = (int)$_GET['id'];
$stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
$stmt->execute([$id]);
header('Location: index.php');
exit;
?>