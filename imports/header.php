<?php include 'imports/variables.php'; ?>

<header>
  <div class="header-bar">
    <a href="/">
      <img src="/images/PMsignature-transparent.webp" alt="PM">
    </a>
    <img src ="/images/PMBanner-white.webp" alt="Peter MacAulay" class = "banner">

    <nav class="nav-buttons">
      <?php
      foreach ($navbarLinks as $label => $url) {
        echo "<a href='$url'><button>$label</button></a>";
      }
      ?>
    </nav>
  </div>
</header>
