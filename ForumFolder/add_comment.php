<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../db.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;
if (!isset($_SESSION['user_id'])) { http_response_code(403); exit; }
if (!validate_csrf($_POST['csrf'] ?? '')) die('Bad CSRF');
$post_id = intval($_POST['post_id'] ?? 0);
$content = trim($_POST['content'] ?? '');
if (!$post_id || $content === '') die('Bad data');
$stmt = $pdo->prepare('INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)');
$stmt->execute([$post_id, $_SESSION['user_id'], $content]);
header('Location: /?nav=post&id=' . urlencode($post_id));
exit;