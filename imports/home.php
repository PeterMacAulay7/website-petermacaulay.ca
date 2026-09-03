<!-- Intro section -->
<div class="contentbox text-only">
  <div class="text">
    <p>This site is a space where I build, experiment, and share projects, writing, and ideas as they develop.</p>
    <p>If you're new here, you can see what I've been up to recently on this homepage. Every section of this homepage should lead to other parts of the site with more information</p>
    <p>You can read more about me and my intentions behind creating this website on my about page <a href="/about">here</a>.</p>
  </div>
</div>

<div style="text-align: center; margin-bottom: 30px;">
  <a href="Resume.pdf" target="_blank"><button>Comp. Sci. Resume</button></a>
  <a href="General Resume.pdf" target="_blank"><button>General Resume</button></a>
</div>

<!-- Most Recent section -->
<h2 style="text-align: center; margin-top: 40px;">Most Recent</h2>

<div style="margin-bottom: 40px;">
  <h3 style="text-align: center;"><a href="?nav=projects">Latest Project</a></h3>
  <?php echo get_first_div('imports/projects.php', 'contentbox'); ?>
</div>

<?php
$latestBlogPath = get_latest_post_by_internal_date('blogposts');
$latestBlogSlug = $latestBlogPath
    ? basename($latestBlogPath, '.html')
    : null;
?>

<div style="margin-bottom: 40px;">
  <h3 style="text-align: center;">
    <a href="/blog/<?php echo urlencode($latestBlogSlug); ?>">
      Latest Blog Post
    </a>
  </h3>
  <a href="/blog/<?php echo urlencode($latestBlogSlug); ?>" style="text-decoration: none;">
    <?php
    echo $latestBlogPath
      ? get_first_div($latestBlogPath, 'contentbox')
      : "<div class='contentbox'><p>No blog posts yet.</p></div>";
    ?>
  </a>
</div>

<?php
$latestEssayPath = get_latest_post_by_internal_date('essayfolder');
$latestEssaySlug = $latestEssayPath
    ? basename($latestEssayPath, '.html')
    : null;
?>

<div style="margin-bottom: 40px;">
  <h3 style="text-align: center;">
    <a href="/essays/<?php echo urlencode($latestEssaySlug); ?>">
      Latest Essay
    </a>
  </h3>
  <a href="/essays/<?php echo urlencode($latestEssaySlug); ?>" style="text-decoration: none;">
    <?php
    echo $latestEssayPath
      ? get_first_div($latestEssayPath, 'contentbox')
      : "<div class='contentbox'><p>No essays yet.</p></div>";
    ?>
  </a>
</div>