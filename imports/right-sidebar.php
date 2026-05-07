<?php
require_once __DIR__ . '/functions.php';

$recentMovies = getRecentMovies(3); // or 2–3
?>

<div class="sidebar">

  <!-- Next Improv Show -->
  <div class="sidebar-section">
    <h2>Next Improv Show:</h2>
    <div class="scroll-box">
      <ul>
        <li>I'm currently looking for a new Improv group in Charlottetown PEI so if anyone knows of any, please let me know, Thanks</li>
        <li>Unfortunately, MtA Presents had it's last show of the school year on Monday April 7th</li>
        <li>My time on MtA Presents will always stay with me and I will be forever grateful for the time I had.</li>
        <li>Shows where on Mondays at 9:30 @ The Pond but they have now finished for the year.</li>
      </ul>
    </div>
  </div>

  <!-- Last GitHub Commit -->
  <div class="sidebar-section">
    <h2>Last GitHub Commit:</h2>
    <div class ="scroll-box">
      <ul class="sidebar-list">
        <?php
          $url = "https://api.github.com/repos/PeterMacAulay7/website-petermacaulay.ca/commits?per_page=1";

          $options = [
            "http" => [
              "method" => "GET",
              "header" => "User-Agent: petermacaulay.ca\r\n"
            ]
          ];

          $context = stream_context_create($options);
          $response = file_get_contents($url, false, $context);

          if ($response !== false) {
            $commits = json_decode($response, true);

            if (!empty($commits)) {
              $latest = $commits[0];
              $message = htmlspecialchars($latest["commit"]["message"]);
              $date = date("M j, Y", strtotime($latest["commit"]["author"]["date"]));
              $link = $latest["html_url"];

              echo "<li>";
              echo "<a href='$link' target='_blank'>$message </a>";
              echo "<small><br>$date</small>";
              echo "</li>";
            }
          }
        ?>
      </ul>
    </div>
  </div>

<div class="sidebar-section">
  <h2>Most Recently Watched Movies:</h2>

  <div class="scroll-box">
    <ul>
      <?php foreach ($recentMovies as $m): ?>
        <li>
          <?php echo htmlspecialchars($m["title"]); ?> 
          - <?php echo htmlspecialchars($m["year"]); ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>

  <p class="sidebar-note">
    You can see my <a href="/movies">full movie library here</a>
  </p>
</div>

</div>
