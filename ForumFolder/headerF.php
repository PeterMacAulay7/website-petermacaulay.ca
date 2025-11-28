<!-- headerF.php -->
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../db.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>My Microblog</title>
  <link rel="stylesheet" href="/ForumFolder/styleForum.css">
</head>
<body>
<header class="topbar">
  <div class="container">
    <a class="brand" href="?nav=forum">Peters Forum</a>
    <nav>
      <?php if (isset($_SESSION['user_id'])): ?>
        <a href="/?nav=logout">Log out (<?php echo e($_SESSION['username']); ?>)</a>
      <?php else: ?>
        <a href="/?nav=login">Log in</a>
        <a href="/?nav=register">Register</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
<main class="container">