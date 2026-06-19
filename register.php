<?php
require 'config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $password]);
        header('Location: login.php');
        exit;
    } catch(PDOException $e) {
        $error = "Username already exists!";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<body>
<h1>Register</h1>
<?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
<form method="POST">
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Register</button>
</form>
<a href="login.php">Already have an account? Login</a>
</body>
</html>