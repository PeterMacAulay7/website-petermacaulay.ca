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
        <p>
          You can learn more about my motivation behind this website by perusing the actual site. That being said, the short of it is that I think a project like building a website gives me an 
          excuse to create things I care about and actually share them with the world in the way I want to.<br>
          It allows me to have a stronger foundation for continued growth; otherwise it feels like building on top of a quick sand tower. By having my previous work released to the world 
          it solidly cements it in place, giving a strong foundation to build that tower on. This way I can feel more connected with the greater world around me, because I now have something to point to; 
          I am no longer incoherently babbling about things that are only in my head.<br>
          My hope is that others will follow suit by creating their own websites. I really think it's a valuable exercise that can provide you with something that you may be looking for, even if you don't know it yet.
        </p>
    </section>
  </div>

  <div class="outter">
    <h2>Most Recent:</h2>
    <nav>
      <h3><a href = "?nav=projects">Latest Project</a></h3>
      <?php echo get_first_div('imports/projects.php', 'contentbox'); ?>

      <h3><a href = "?nav=blog">Latest Blog Post</a></h3>
      <?php
      $latest = get_latest_post_by_internal_date('blogposts');
      echo $latest ? get_first_div($latest, 'contentbox') : "<p>No blog posts yet.</p>";
      ?>

      <h3><a href = "?nav=essays">Latest Essay</a></h3>
      <?php
      $latest = get_latest_post_by_internal_date('essayfolder');
      echo $latest ? get_first_div($latest, 'contentbox') : "<p>No essays yet.</p>";
      ?>
    </nav>
  </div>

</body>
</html>
