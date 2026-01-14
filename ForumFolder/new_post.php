<link rel="stylesheet" href="/ForumFolder/styleForum.css">

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../db.php';
if (!isset($_SESSION['user_id'])) { header('Location: /?nav=forum'); exit; }
//include __DIR__ . '/headerF.php';
?>
<?php include 'ForumFolder/headerF.php';?>
<div class="card">
  <h2>New Post</h2>
  <form action="/?nav=add_post" method="post">
    <input type="hidden" name="csrf" value="<?php echo e(csrf_token()); ?>">
    <textarea name="content" maxlength="1000" required placeholder="What's on your mind?"></textarea>
    <div style="margin-top:8px"><button type="submit">Post</button></div>
  </form>
</div>
<//?php include __DIR__ . '/footerF.php'; ?>