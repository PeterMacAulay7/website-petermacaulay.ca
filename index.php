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
  case 'forum':
    $pageHeaderHTML = '<h1>Forum</h1>';
    $pageFile = 'ForumFolder/forum.php';
    break;
  case 'new_post':
    $pageHeaderHTML = '<h1>New Post</h1>';
    $pageFile = 'ForumFolder/new_post.php';
    break;
  case 'register':
    $pageHeaderHTML = '<h1>Register For Forum</h1>';
    $pageFile = 'ForumFolder/register.php';
    break;
  case 'post':
    $pageHeaderHTML = '<h1>Post</h1>';
    $pageFile = 'ForumFolder/post.php';
    break;
  case 'login':
    $pageHeaderHTML = '<h1>login</h1>';
    $pageFile = 'ForumFolder/login.php';
    break;
  case 'logout':
    $pageHeaderHTML = '<h1>logout</h1>';
    $pageFile = 'ForumFolder/logout.php';
    break;
  case 'add_comment':
    $pageHeaderHTML = '<h1>add comment</h1>';
    $pageFile = 'ForumFolder/add_comment.php';
    break;
  case 'add_post':
    $pageHeaderHTML = '<h1>add post</h1>';
    $pageFile = 'ForumFolder/add_post.php';
    break;
  case 'upload_profile':
    $pageHeaderHTML = '<h1>upload profile</h1>';
    $pageFile = 'ForumFolder/upload_profile.php';
    break;
  case 'delete_post':
    $pageHeaderHTML = '<h1>delete post</h1>';
    $pageFile = 'ForumFolder/delete_post.php';
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
  <link rel="stylesheet" href="/style.css?v=1.1">

  <?php if (isset($_GET['page'])): ?>
  <link rel="canonical" href="https://petermacaulay.ca/<?php echo $nav; ?>/<?php echo htmlspecialchars($_GET['page']); ?>">
  <?php else: ?>
  <link rel="canonical" href="https://petermacaulay.ca/<?php echo $nav; ?>">
  <?php endif; ?>

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
