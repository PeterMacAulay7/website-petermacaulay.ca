<?php
require_once __DIR__ . '/functions.php';

$currentBooks = getCurrentlyReading(); // or 2–3 depending on layout
?>
<div class="sidebar">

  <!-- Currently Reading -->
  <div class="sidebar-section">
    <h2>Currently Reading:</h2>
    <div class="scroll-box">
      <ul>
        <?php foreach ($currentBooks as $b): ?>
            <li>
                <?php echo htmlspecialchars($b["title"]); ?> - 
                <?php echo htmlspecialchars($b["author"]); ?>
            </li>
        <?php endforeach; ?>
      </ul>

    </div>
    <p class="sidebar-note">
      <center><a href="/books" target="_blank"><button>Full Book Library</button></a></center>
    </p>
  </div>

  <!-- Music -->
  <div class="sidebar-section">
    <h2>Currently On Repeat:</h2>
    <p class="sidebar-note">These are the top 5 albums I've listened to this month using real data from my MP3 player:</p>
    <div class="scroll-box">
    <?php
    $data = json_decode(file_get_contents(__DIR__ . "/../web_output/mp3_monthly_albums.json"), true);

    foreach ($data["albums"] as $a) {
      echo "<li>{$a['album']} - {$a['artist']}</li>";
    }
    ?>
    </div>

    <p class="sidebar-note">
      Please give me recommendations I’m always looking for new music.
      I can also give you recommendations if you want. Or you can check out <center><a href="/music" target="_blank"><button>Full Music Library</button></a></center>
    </p>
    <p class="sidebar-note">
      Or you can check out my <center><a href="/wrapped" target="_blank"><button>MP3 Wrapped</button></a></center>  
  </div>

  <!-- Friends -->
  <div class="sidebar-section">
    <h2>Friends’ Websites</h2>
    <center><nav> <a href="https://bennettbeaumont.com"><button>Ben Beaumont <img src="/bennettbeaumont.com/TheIcon.webp" style="width:20px;height:auto;"></button></a> </nav></center>
  </div>

</div>
