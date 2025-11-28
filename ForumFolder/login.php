<link rel="stylesheet" href="/ForumFolder/styleForum.css">

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../db.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf($_POST['csrf'] ?? '')) {
        $errors[] = 'Invalid CSRF token.';
    }
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if (!$username || !$password) $errors[] = 'Provide username and password.';
    if (empty($errors)) {
        $stmt = $pdo->prepare('SELECT id, password_hash FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $row = $stmt->fetch();
        if ($row && password_verify($password, $row['password_hash'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $username;
            header('Location: /?nav=forum');
            exit;
        } else {
            $errors[] = 'Invalid credentials.';
        }
    }
}
?>
<div class ="card">
    <?php include 'ForumFolder/headerF.php';?>
</div>
<div class="card">
  <h2>Log in</h2>
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
      <button type="submit">Log in</button>
    </div>
  </form>
</div>
<?php// include __DIR__ . '/footerF.php'; ?>