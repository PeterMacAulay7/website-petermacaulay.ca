<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Homepage|Peter MacAulay</title>
  <meta name="description" content="Developer, Philosopher, and Improvisor">
</head>

<body>
  <div>
    <section>
    </section>

    <section>
      <div class="contentbox">
        <div class="text">
          <p>This site is a space where I build, experiment, and share projects, writing, and ideas as they develop.</p>
          <p>If you're new here, you can see what I've been up to recently on this homepage. Every section of this homepage should lead to other parts of the site with more information</p>
          <p>You can read more about me and my intentions behind creating this website on my about page <a href="/about">here</a>.</p>
        </div>
      </div>
        <a href="Resume.pdf" target="_blank"><button>Comp. Sci. Resume</button></a>
        <a href="General Resume.pdf" target="_blank"><button>General Resume</button></a>
    </section>
  </div>

  <div class="outter">
    <center><h2>Most Recent:</h2></center>
    <nav>
      <center><h3><a href = "?nav=projects">Latest Project</a></h3></center>
      <?php echo get_first_div('imports/projects.php', 'contentbox'); ?>

    <?php
    $latestBlogPath = get_latest_post_by_internal_date('blogposts');

    $latestBlogSlug = $latestBlogPath
        ? basename($latestBlogPath, '.html')
        : null;
    ?>

    <center><h3>
      <a href="/blog/<?php echo urlencode($latestBlogSlug); ?>">
        Latest Blog Post
      </a>
    </h3></center>

    <a href="/blog/<?php echo urlencode($latestBlogSlug); ?>">
    <?php
    echo $latestBlogPath
      ? get_first_div($latestBlogPath, 'contentbox')
      : "<p>No blog posts yet.</p>";
    ?>
    </a>


    <?php
    $latestEssayPath = get_latest_post_by_internal_date('essayfolder');

    $latestEssaySlug = $latestEssayPath
        ? basename($latestEssayPath, '.html')
        : null;
    ?>

    <center><h3>
      <a href="/essays/<?php echo urlencode($latestEssaySlug); ?>">
        Latest Essay
      </a>
    </h3>



    <a href="/essays/<?php echo urlencode($latestEssaySlug); ?>">
    <?php
    echo $latestEssayPath
      ? get_first_div($latestEssayPath, 'contentbox')
      : "<p>No essays yet.</p>";
    ?>
  </a>

  </div>

</body>
</html>
