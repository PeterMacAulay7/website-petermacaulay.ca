<link rel="stylesheet" href="/ForumFolder/styleForum.css">
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../db.php';
// fetch latest posts with author info
$stmt = $pdo->query('SELECT posts.*, users.username, users.profile_pic FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC LIMIT 50');
$posts = $stmt->fetchAll();
?>
<?php include 'ForumFolder/headerF.php';?>
<div class="card">
  <h2>Timeline</h2>
  <?php if (isset($_SESSION['user_id'])): ?>
    <div style="margin-bottom:10px">
      <a href="/?nav=new_post"><button>Write a new post</button></a>
    </div>
  <?php endif; ?>

  <?php foreach ($posts as $p): ?>
    <article class="card">
      <div class="post-head">
        <?php
          $avatar = $p['profile_pic'] ? ('/ForumFolder/' . $p['profile_pic']) : '/ForumFolder/img/default_avatar.png';
        ?>
        <img src="<?php echo e($avatar); ?>" alt="avatar" class="avatar">
        <div>
          <div><strong><?php echo e($p['username']); ?></strong> <span class="post-meta">· <?php echo e(time_ago($p['created_at'])); ?></span></div>
          <div class="post-content"><?php echo e($p['content']); ?></div>
            <div class="actions small">
              <button onclick="location.href='/?nav=post&id=<?= urlencode($p['id']) ?>'">
                Comments
              </button>
            </div>
        </div>
      </div>
    </article>
  <?php endforeach; ?>
</div>
