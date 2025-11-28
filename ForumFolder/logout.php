<link rel="stylesheet" href="/ForumFolder/styleForum.css">

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../db.php';
session_unset();
session_destroy();
header('Location: /?nav=forum');
exit;