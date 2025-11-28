<link rel="stylesheet" href="/ForumFolder/styleForum.css">

<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/../db.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: /?nav=login'); exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /?nav=forum'); exit;
}
if (!validate_csrf($_POST['csrf'] ?? '')) {
    die('Invalid CSRF token');
}

if (!isset($_FILES['profile_pic']) || $_FILES['profile_pic']['error'] !== UPLOAD_ERR_OK) {
    die('No file uploaded');
}

$allowed = ['image/png','image/jpeg','image/gif'];
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $_FILES['profile_pic']['tmp_name']);
if (!in_array($mime, $allowed)) die('Invalid file type');
$maxSize = 2 * 1024 * 1024; // 2MB
if ($_FILES['profile_pic']['size'] > $maxSize) die('File too large');


// prepare target directory
$dir = __DIR__ . '/img';
if (!is_dir($dir)) mkdir($dir, 0755, true);

$ext = $mime === 'image/png' ? 'png' : ($mime === 'image/gif' ? 'gif' : 'jpg');
$userid = intval($_SESSION['user_id']);
$target = $dir . "/user_$userid.$ext";

// Resize and crop to square 96x96 using GD
$src = null;
if ($ext === 'png') $src = imagecreatefrompng($_FILES['profile_pic']['tmp_name']);
elseif ($ext === 'gif') $src = imagecreatefromgif($_FILES['profile_pic']['tmp_name']);
else $src = imagecreatefromjpeg($_FILES['profile_pic']['tmp_name']);

if (!$src) die('Failed to load image');
$w = imagesx($src);
$h = imagesy($src);
$size = min($w, $h);
$src_x = intval(($w - $size) / 2);
$src_y = intval(($h - $size) / 2);
$dst = imagecreatetruecolor(96,96);
// preserve transparency for PNG/GIF
if ($ext === 'png' || $ext === 'gif') {
    imagecolortransparent($dst, imagecolorallocatealpha($dst, 0, 0, 0, 127));
    imagealphablending($dst, false);
    imagesavealpha($dst, true);
}
imagecopyresampled($dst, $src, 0,0, $src_x, $src_y, 96,96, $size, $size);

// Save
if ($ext === 'png') imagepng($dst, $target);
elseif ($ext === 'gif') imagegif($dst, $target);
else imagejpeg($dst, $target, 85);

imagedestroy($src);
imagedestroy($dst);

// update DB
$relative = 'img/user_' . $userid . '.' . $ext;
$stmt = $pdo->prepare('UPDATE users SET profile_pic = ? WHERE id = ?');
$stmt->execute([$relative, $userid]);

header('Location: /?nav=forum');
exit;