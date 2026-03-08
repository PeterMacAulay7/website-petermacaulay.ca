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

  <textarea id="postContent" name="content" maxlength="1000" required placeholder="What's on your mind?"></textarea>

  <div class="post-controls">
    <button type="button" id="emojiBtn">😀</button>
    <button type="submit">Post</button>
  </div>
</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@4/dist/index.min.js"></script>
<script>

const button = document.querySelector('#emojiBtn');
const textarea = document.querySelector('#postContent');

const picker = new EmojiButton({
  position: 'top-start',
  autoHide: true,
  theme: 'dark'
});

button.addEventListener('click', () => {
  picker.togglePicker(button);
});

picker.on('emoji', emoji => {
  textarea.value += emoji;
  textarea.focus();
});

</script>
