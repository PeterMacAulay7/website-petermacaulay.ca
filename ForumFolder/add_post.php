<link rel="stylesheet" href="/ForumFolder/styleForum.css">

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../db.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;
if (!isset($_SESSION['user_id'])) { http_response_code(403); exit; }
if (!validate_csrf($_POST['csrf'] ?? '')) die('Bad CSRF');
$content = trim($_POST['content'] ?? '');
if ($content === '') die('Empty post');
if (mb_strlen($content) > 1000) die('Too long');
$stmt = $pdo->prepare('INSERT INTO posts (user_id, content) VALUES (?,?)');
$stmt->execute([$_SESSION['user_id'], $content]);
header('Location: /?nav=forum');
exit;