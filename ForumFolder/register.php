<link rel="stylesheet" href="/ForumFolder/styleForum.css">

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once $_SERVER['DOCUMENT_ROOT'] . '/../db.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf($_POST['csrf'] ?? '')) {
        $errors[] = 'Invalid CSRF token.';
    }
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if (strlen($username) < 3) $errors[] = 'Username too short.';
    if (strlen($password) < 6) $errors[] = 'Password must be at least 6 chars.';

    if (empty($errors)) {
        // check uniqueness
        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $errors[] = 'Username already taken.';
        } else {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare('INSERT INTO users (username, password_hash) VALUES (?, ?)');
            $stmt->execute([$username, $hash]);
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['username'] = $username;
            header('Location: /?nav=forum');
            exit;
        }
    }
}
//include __DIR__ . '/headerF.php';
?>
<div class="card">
  <h2>Register</h2>
  <?php foreach ($errors as $err): ?>
    <div class="small" style="color:#c00"><?php echo e($err); ?></div>
  <?php endforeach; ?>
  <form method="post">
    <input name="csrf" type="hidden" value="<?php echo e(csrf_token()); ?>">
    <label>Username</label>
    <input name="username" required>
    <label>Password</label>
    <input name="password" type="password" required>
    <div style="margin-top:8px">
      <button type="submit">Register</button>
    </div>
  </form>
</div>
<?php// include __DIR__ . '/footerF.php'; ?>