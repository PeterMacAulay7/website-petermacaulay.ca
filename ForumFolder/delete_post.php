<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /?nav=forum');
    exit;
}

if (!validate_csrf($_POST['csrf'] ?? '')) {
    die("Invalid CSRF token.");
}

if (!isset($_SESSION['user_id'])) {
    header('Location: /?nav=login');
    exit;
}

$post_id = intval($_POST['post_id'] ?? 0);

// Verify ownership
$stmt = $pdo->prepare("SELECT user_id FROM posts WHERE id = ?");
$stmt->execute([$post_id]);
$row = $stmt->fetch();

if (!$row || $row['user_id'] != $_SESSION['user_id']) {
    die("You are not allowed to delete this post.");
}

// Delete comments first (FK may already do this depending on DB)
$pdo->prepare("DELETE FROM comments WHERE post_id = ?")->execute([$post_id]);

// Delete post
$pdo->prepare("DELETE FROM posts WHERE id = ?")->execute([$post_id]);

header("Location: /?nav=forum");
exit;
