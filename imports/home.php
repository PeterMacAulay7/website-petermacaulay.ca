<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Homepage|Peter MacAulay</title>
  <meta name="description" content="Improvisor, Philosopher, Developer, and Neo-Polymath">
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
        <p>
          *note* if you haven't been here in a while, try ctrl + f5 to refresh the page so you don't miss the latest updates!
        </p>
    </section>
  </div>

  <div class="outter">
    <h2>Most Recent:</h2>

    <h3>Blog Post</h3>
    <?php echo get_first_div('imports/blog.php', 'contentbox'); ?>

    <h3>Essay</h3>
    <?php echo get_first_div('imports/essays.php', 'contentbox'); ?>

    <h3>Project</h3>
    <?php echo get_first_div('imports/projects.php', 'contentbox'); ?>
  </div>

</body>
</html>
