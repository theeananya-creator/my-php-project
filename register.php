<?php
require 'config.php';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Server-side validation
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username)) {
        $errors[] = "Username is required!";
    } elseif (strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters!";
    } elseif (strlen($username) > 50) {
        $errors[] = "Username must be less than 50 characters!";
    }

    if (empty($password)) {
        $errors[] = "Password is required!";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters!";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match!";
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'editor')");
            $stmt->execute([$username, $hashed_password]);
            header('Location: login.php?registered=1');
            exit;
        } catch(PDOException $e) {
            $errors[] = "Username already exists!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="text-center mb-4">📝 Register</h2>
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <form method="POST" novalidate>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control"
                                   value="<?= htmlspecialchars($username ?? '') ?>"
                                   minlength="3" maxlength="50" required>
                            <div class="form-text">At least 3 characters</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control"
                                   minlength="6" required>
                            <div class="form-text">At least 6 characters</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </form>
                    <p class="text-center mt-3">Already have an account? <a href="login.php">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>