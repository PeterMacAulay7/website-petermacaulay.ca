<?php
$mp3jsonPath = __DIR__ . "/../web_output/mp3_albums.json";
$mp3_albums = json_decode(file_get_contents($mp3jsonPath), true);

// Randomize order each page load
if (is_array($mp3_albums)) {
    shuffle($mp3_albums);
}

$cdjsonPath = __DIR__ . "/../web_output/cd_albums.json";
$cd_albums = json_decode(file_get_contents($cdjsonPath), true);

// Randomize order each page load
if (is_array($cd_albums)) {
    shuffle($cd_albums);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Music Archive</title>
</head>
<body>

<a class="back-link" href="/library">← Back to Library</a>
<br>
<p>Nav</p>
<a href="#MP3">MP3 Collection</a><br>
<a href="#CD">CD Collection</a><br>

<h2 id = "MP3">MP3 Collection</h2>
<div class="media-grid">
<?php foreach ($mp3_albums as $a): ?>
    <div class="element">
            <a href="/album?artist=<?php echo urlencode($a['artist']); ?>&album=<?php echo urlencode($a['album']); ?>">
            <?php if ($a["cover"]): ?>
                <img src="/web_output/<?php echo htmlspecialchars($a["cover"]); ?>?v=<?php echo filemtime("web_output/" . $a["cover"]); ?>" loading="lazy">
            <?php else: ?>
                <div class="no-cover">No Cover</div>
            <?php endif; ?>
        </a>

        <div class="info">
            <strong><?php echo htmlspecialchars($a["album"]); ?></strong>
            <span><?php echo htmlspecialchars($a["artist"]); ?></span>
        </div>
    </div>
<?php endforeach; ?>
</div>

<h2 id = "CD">CD Collection</h2>
<div class="media-grid">
<?php foreach ($cd_albums as $a): ?>
    <div class="element">
            <a href="/album?artist=<?php echo urlencode($a['artist']); ?>&album=<?php echo urlencode($a['album']); ?>">
            <?php if ($a["cover"]): ?>
                <img src="/web_output/<?php echo htmlspecialchars($a["cover"]); ?>?v=<?php echo filemtime("web_output/" . $a["cover"]); ?>" loading="lazy">
            <?php else: ?>
                <div class="no-cover">No Cover</div>
            <?php endif; ?>
        </a>

        <div class="info">
            <strong><?php echo htmlspecialchars($a["album"]); ?></strong>
            <span><?php echo htmlspecialchars($a["artist"]); ?></span>
        </div>
    </div>
<?php endforeach; ?>
</div>
</body>
</html>
