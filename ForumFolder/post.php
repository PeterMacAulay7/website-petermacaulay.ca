<link rel="stylesheet" href="/ForumFolder/styleForum.css">

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../db.php';
$id = intval($_GET['id'] ?? 0);
if (!$id) { header('Location: /?nav=forum'); exit; }
$stmt = $pdo->prepare('SELECT posts.*, users.username, users.profile_pic FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id = ?');
$stmt->execute([$id]);
$post = $stmt->fetch();
if (!$post) { header('Location: /?nav=forum'); exit; }
// comments
$cstmt = $pdo->prepare('SELECT comments.*, users.username, users.profile_pic FROM comments JOIN users ON comments.user_id = users.id WHERE comments.post_id = ? ORDER BY comments.created_at ASC');
$cstmt->execute([$id]);
$comments = $cstmt->fetchAll();
?>

<div class ="card">
    <?php include 'ForumFolder/headerF.php';?>
</div>
<div class="card">
  <div class="post-head">
    <?php $avatar = $post['profile_pic'] ? ('/ForumFolder/' . $post['profile_pic']) : '/ForumFolder/img/default_avatar.png'; ?>
    <img src="<?php echo e($avatar); ?>" class="avatar">
    <div>
      <strong><?php echo e($post['username']); ?></strong> <span class="post-meta">· <?php echo e(time_ago($post['created_at'])); ?></span>
      <div class="post-content"><?php echo e($post['content']); ?></div>
    </div>
  </div>
</div>

<div class="card">
  <h3>Comments</h3>
  <?php if (count($comments) === 0): ?>
    <div class="small">No comments yet.</div>
  <?php endif; ?>
  <?php foreach ($comments as $c): ?>
    <div style="display:flex;gap:10px;margin-top:12px">
      <?php $ca = $c['profile_pic'] ? ('/ForumFolder/' . $c['profile_pic']) : '/ForumFolder/img/default_avatar.png'; ?>
      <img src="<?php echo e($ca); ?>" class="avatar" style="width:36px;height:36px">
      <div>
        <div><strong><?php echo e($c['username']); ?></strong> <span class="small">· <?php echo e(time_ago($c['created_at'])); ?></span></div>
        <div><?php echo e($c['content']); ?></div>
      </div>
    </div>
  <?php endforeach; ?>

  <?php if (isset($_SESSION['user_id'])): ?>
    <form action="/?nav=add_comment" method="post" style="margin-top:12px">
      <input type="hidden" name="csrf" value="<?php echo e(csrf_token()); ?>">
      <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
      <textarea name="content" required placeholder="Write a comment..."></textarea>
      <div style="margin-top:8px"><button type="submit">Comment</button></div>
    </form>
  <?php else: ?>
    <div class="small">Please <a href="/?nav=login">log in</a> to comment.</div>
  <?php endif; ?>
</div>

<?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['user_id']): ?>
  <form method="post" action="/?nav=delete_post" style="margin-top:10px">
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
    <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
    <button type="submit" class="danger-btn">Delete</button>
  </form>
<?php endif; ?>