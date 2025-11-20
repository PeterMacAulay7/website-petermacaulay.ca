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

// define both header + content paths in one switch
switch ($nav) {
  case 'home':
    $pageHeaderHTML = '
      <h1>Welcome to my website!</h1>
      <p><b>Developer, Philosopher, Improvisor, and Neo-Polymath</b></p>';
    $pageFile = 'imports/home.php';
    break;

  case 'about':
    $pageHeaderHTML = '<h1>About Me!</h1>';
    $pageFile = 'imports/about.php';
    break;

  case 'blog':
    $pageHeaderHTML = '<h1>Blog!</h1>';
    $pageFile = 'imports/blog.php';
    break;

  case 'essays':
    $pageHeaderHTML = '<h1>Essays</h1>';
    $pageFile = 'imports/essays.php';
    break;

  case 'projects':
    $pageHeaderHTML = '<h1>Projects</h1>';
    $pageFile = 'imports/projects.php';
    break;

  case 'contact':
    $pageHeaderHTML = '<h1>Contact : &#41</h1>';
    $pageFile = 'imports/contact.php';
    break;

  default:
    $pageHeaderHTML = '<h1>Page Not Found</h1>';
    $pageFile = '404.php';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Peter MacAulay | <?php echo ucfirst($nav); ?></title>
  <link rel="icon" href="PMsignature.png">
  <link rel="stylesheet" href="style.css?v=1.1">
</head>

<body>
  <?php include 'imports/header.php'; ?>

  <div class="page-header">
    <?php echo $pageHeaderHTML; ?>
  </div>

  <main>
    <?php include 'imports/left-sidebar.php'; ?>

    <div class="main-content">
      <?php include $pageFile; ?>
    </div>
    
    <?php include 'imports/right-sidebar.php'; ?>
  </main>

  <?php include 'imports/footer.php'; ?>
</body>
</html>
