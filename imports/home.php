<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Homepage|Peter MacAulay</title>
  <meta name="description" content="Developer, Philosopher, Improvisor, and Neo-Polymath">
</head>

<body>
  <div>
    <section>
      <h2>What is this Page?</h2>
        <p>This is a page where I'll be learning how to design a website, 
          along with sharing what I make with the world.</p>
    </section>

    <section>
      <h2>Why I Made This</h2>
        <p>I’ve always wanted a space to learn, build, and reflect in public — 
          this site is where I’m figuring that out. Everything here is handmade and in progress.</p>
    </section>
  </div>

  <div class="outter">
    <h2>Most Recent:</h2>
    <nav>
      <h3><a href = "?nav=blog">Latest Blog Post</a></h3>
      <?php
        $posts = glob('blogposts/*.html');

        // sort newest first
        usort($posts, function($a, $b) {
            return filemtime($b) - filemtime($a);
        });

        $latest = $posts[0] ?? null;

        if ($latest) {
            echo get_first_div($latest, 'contentbox');
        } else {
            echo "<p>No blog posts yet.</p>";
        }
      ?>

      <h3><a href = "?nav=essays">Latest Essay</a></h3>
      <?php echo get_first_div('imports/essays.php', 'contentbox'); ?>

      <h3><a href = "?nav=projects">Latest Project</a></h3>
      <?php echo get_first_div('imports/projects.php', 'contentbox'); ?>
    </nav>
  </div>

</body>
</html>
