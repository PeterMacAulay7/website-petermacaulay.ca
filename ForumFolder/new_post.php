<link rel="stylesheet" href="/ForumFolder/styleForum.css">

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../db.php';
if (!isset($_SESSION['user_id'])) { header('Location: /?nav=forum'); exit; }
//include __DIR__ . '/headerF.php';
?>
<?php include 'ForumFolder/headerF.php';?>
<div class="card">
  <h2>New Post</h2>
<form action="/?nav=add_post" method="post" enctype="multipart/form-data">
  <input type="hidden" name="csrf" value="<?php echo e(csrf_token()); ?>">

  <textarea id="postContent" name="content" maxlength="1000" required placeholder="What's on your mind?"></textarea>

  <div class="post-controls">
    <label for="imageInput" class="image-upload-btn">🖼️</label>
      <input 
        type="file" 
        id="imageInput" 
        name="image" 
        accept="image/*"
        hidden
      >
    <button type="submit">Post</button>
  </div>
</form>
</div>

<span id="fileName"></span>

<script>
imageInput.onchange = () => fileName.textContent = imageInput.files[0]?.name || '';
</script>
