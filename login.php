<?php
require 'config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username=?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: index.php');
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
<h1>Login</h1>
<?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
<form method="POST">
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Login</button>
</form>
<a href="register.php">Don't have an account? Register</a>
</body>
</html>