<link rel="stylesheet" href="/ForumFolder/styleForum.css">

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../db.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;
if (!isset($_SESSION['user_id'])) { http_response_code(403); exit; }
if (!validate_csrf($_POST['csrf'] ?? '')) die('Bad CSRF');
$content = trim($_POST['content'] ?? '');

$imagePath = null;

if (!empty($_FILES['image']['name'])) {

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

    if (!in_array($_FILES['image']['type'], $allowedTypes)) {
        die('Invalid file type');
    }

    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/ForumFolder/uploads/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Create image from file
    $tmp = $_FILES['image']['tmp_name'];
    $type = $_FILES['image']['type'];

    if ($type === 'image/jpeg') {
        $src = imagecreatefromjpeg($tmp);
    } elseif ($type === 'image/png') {
        $src = imagecreatefrompng($tmp);
    } elseif ($type === 'image/gif') {
        $src = imagecreatefromgif($tmp);
    } else {
        die('Unsupported image type');
    }

    if (!$src) die('Image error');

    // Get original size
    $width = imagesx($src);
    $height = imagesy($src);

    //Resize (max width = 800px)
    $maxWidth = 800;
    if ($width > $maxWidth) {
        $newWidth = $maxWidth;
        $newHeight = intval($height * ($maxWidth / $width));
    } else {
        $newWidth = $width;
        $newHeight = $height;
    }

    $resized = imagecreatetruecolor($newWidth, $newHeight);

    // Preserve transparency for PNG
    imagealphablending($resized, false);
    imagesavealpha($resized, true);

    imagecopyresampled($resized, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    // Save as WebP
    $filename = time() . '.webp';
    $targetFile = $uploadDir . $filename;

    imagewebp($resized, $targetFile, 80); // quality 0–100

    imagedestroy($src);
    imagedestroy($resized);

    $imagePath = 'uploads/' . $filename;
}

if ($content === '' && empty($_FILES['image']['name'])) {
    die('Post must have text or an image');
}
if (mb_strlen($content) > 1000) die('Too long');
$stmt = $pdo->prepare('INSERT INTO posts (user_id, content, image) VALUES (?, ?, ?)');
$stmt->execute([
    $_SESSION['user_id'],
    $content,
    $imagePath
]);
header('Location: /?nav=forum');
exit;


