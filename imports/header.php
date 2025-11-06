<?php include 'imports/variables.php'; ?>

<header>
  <div class="header-bar">
    <a href="/">
      <img src="/images/PMsignature.png" alt="PM">
    </a>

    <nav class="nav-buttons">
      <?php
      foreach ($navbarLinks as $label => $url) {
        echo "<a href='$url'><button>$label</button></a>";
      }
      ?>
    </nav>
  </div>
</header>
