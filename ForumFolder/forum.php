<link rel="stylesheet" href="/ForumFolder/styleForum.css">
<?php

$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;

require_once $_SERVER['DOCUMENT_ROOT'] . '/../db.php';
// fetch latest posts with author info
$stmt = $pdo->prepare('
SELECT 
  posts.*, 
  users.username, 
  users.profile_pic,
  COUNT(comments.id) AS comment_count
FROM posts
JOIN users ON posts.user_id = users.id
LEFT JOIN comments ON comments.post_id = posts.id
GROUP BY posts.id
ORDER BY posts.created_at DESC
LIMIT :limit
');

$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();

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

  <?php foreach ($posts as $index => $p): ?>
    <article class="card" id="post-<?php echo $index + 1; ?>">
      <div class="post-head">
        <?php
          $avatar = $p['profile_pic'] ? ('/ForumFolder/' . $p['profile_pic']) : '/ForumFolder/img/default_avatar.png';
        ?>
        <img src="<?php echo e($avatar); ?>" alt="avatar" class="avatar" loading="lazy">
        <div>
          <div><strong><?php echo e($p['username']); ?></strong> <span class="post-meta">· <?php echo e(time_ago($p['created_at'])); ?></span></div>
          <div class="post-content"><?php echo format_content($p['content']); ?></div>
            <?php if (!empty($p['image'])): ?>
              <img src="/ForumFolder/<?php echo e($p['image']); ?>" class="post-image" loading="lazy">
            <?php endif; ?>
            <div class="actions small">
              <button onclick="location.href='/?nav=post&id=<?= urlencode($p['id']) ?>'">
                Comments <?= $p['comment_count'] ?>
              </button>
            </div>
        </div>
      </div>
    </article>
  <?php endforeach; ?>
</div>

<a href="/?nav=forum&limit=<?php echo $limit + 10; ?>#post-<?php echo $limit; ?>">
  <button>Load more</button>
</a>
