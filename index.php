<?php

require_once 'imports/functions.php';
// normalize nav
// normalize nav
if (isset($_GET['nav'])) {
  $nav = strtolower(str_replace(" ", "-", $_GET['nav']));
} else {
  // Try to get the path manually (works on most hosts)
  $request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  $nav = trim($request_uri, "/");

  // Default to 'home' if empty
  if ($nav === '' || $nav === 'index.php') {
    $nav = 'home';
  }
}

// 1. Default fallback values
$pageHeaderHTML = '<h1>Welcome to my website!</h1>';
$pageFile = 'imports/home.php';

// 2. Normalize the base navigation directory 
// (e.g., extracts 'blog' out of 'blog/some-post-title')
$uri_parts = explode('/', $nav);
$base_nav = $uri_parts[0]; 

// 3. Separate routing by directory groupings
$forum_pages = ['forum', 'new_post', 'register', 'post', 'login', 'logout', 'add_comment', 'add_post', 'upload_profile', 'delete_post'];

if ($base_nav !== 'home') {
    if (in_array($base_nav, $forum_pages)) {
        $pageFile = "ForumFolder/{$base_nav}.php";
        $pageHeaderHTML = '<h1>' . ucwords(str_replace('_', ' ', $base_nav)) . '</h1>';
    } else {
        $testFile = "imports/{$base_nav}.php";
        if (file_exists($testFile)) {
            $pageFile = $testFile;
            // Format title cleanly (e.g., 'new_post' becomes 'New Post')
            $pageHeaderHTML = '<h1>' . ucwords(str_replace('_', ' ', $base_nav)) . '</h1>';
        } else {
            $pageHeaderHTML = '<h1>Page Not Found</h1>';
            $pageFile = '404.php';
        }
    }
}

// 4. Handle a couple of stubborn unique edge cases manually
if ($base_nav === 'wrapped') {
    $pageHeaderHTML = '<h1>MP3 Wrapped</h1>';
    $pageFile = 'web_output/wrapped.html';
} elseif ($base_nav === 'nadia') {
    $pageHeaderHTML = '<h1>Happy Anniversary Nadia!</h1>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Peter MacAulay | <?php echo ucfirst($nav); ?></title>

  <?php if ($nav === 'wrapped'): ?>
    <base href="/web_output/">
  <?php endif; ?>

  <link rel="icon" href="PMsignature.png">
  <link rel="stylesheet" href="/style.css?v=1.1">

  <?php if (isset($_GET['page'])): ?>
  <link rel="canonical" href="https://petermacaulay.ca/<?php echo $nav; ?>/<?php echo htmlspecialchars($_GET['page']); ?>">
  <?php else: ?>
  <link rel="canonical" href="https://petermacaulay.ca/<?php echo $nav; ?>">
  <?php endif; ?>

</head>

<body class="page-<?php echo $nav; ?>">
  <?php include 'imports/header.php'; ?>

  <div class="page-header">
    <?php echo $pageHeaderHTML; ?>
  </div>

  <main class="<?php echo ($nav === 'home') ? 'homepage-layout' : 'full-width-layout'; ?>">
    
    <?php if ($nav === 'home'): ?>
      <?php include 'imports/left-sidebar.php'; ?>
    <?php endif; ?>

    <div class="main-content">
      <?php include $pageFile; ?>
    </div>
    
    <?php if ($nav === 'home'): ?>
      <?php include 'imports/right-sidebar.php'; ?>
    <?php endif; ?>
  </main>

  <?php include 'imports/footer.php'; ?>
</body>
</html>
