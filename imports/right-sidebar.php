<div class="sidebar">

  <!-- Next Improv Show -->
  <div class="sidebar-section">
    <h2>Next Improv Show:</h2>
    <div class="scroll-box">
      <ul>
        <li>Great News! MtA Presents: The Improv is back for 2026!</li>
        <li>Shows will now be on Mondays at 9:30 @ The Pond.</li>
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
              echo "<small>$date</small>";
              echo "</li>";
            }
          }
        ?>
      </ul>
    </div>
  </div>

  <!-- Status Update -->
  <div class="sidebar-section">
    <h2>Status Update:</h2>
    <div class="scroll-box">
      <ul>
        <li>I just posted my latest project that I was working on in the fall semester. It's a group project that was created as a term project in my Software Design class.</li>

        <li>Just posted a blog post that I'm actually pretty happy with for a quick little post. I've found that these things really help me know what I'm thinking about, so that IRL I have something to back up my thoughts, and I think it will long term help to practice writing.</li>

        <li>I have an essay and a project coming soon. They are both school assignments so I will likely add them mid December after exams.</li>

        <li>Added functionality for displaying content in Blog, Essays, and Projects. I also created fun little images for a couple of projects and an essay. Additionally I wrote a function that can scrape the most recent of each page to display on the home page. – Nov/04/25</li>

        <li>Just updated the page to use the index.php file as a directory for all other pages. It took a lot longer than expected (I guess that's to be expected). – Nov/03/25</li>

        <li>Added a 404 page with amusing photos – Nov/03/25</li>

        <li>Currently learning HTML/CSS/PHP.</li>

        <li>I have big plans for taking the dev side of this website to a new level; you may not see all of it as a visitor. I will have a blog post or project update when I'm done, mostly because those are the types of pages that will be possible with my plans.</li>
      </ul>
    </div>
  </div>

  <!-- TODO -->
  <div class="sidebar-section">
    <h2>TODO:</h2>
    <div class="scroll-box">
      <ul>
        <li>Survive This Semester</li>
      </ul>
    </div>
  </div>

</div>
