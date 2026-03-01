<?php
$mp3jsonPath = __DIR__ . "/../web_output/mp3_albums.json";
$mp3_albums = json_decode(file_get_contents($mp3jsonPath), true);

if (is_array($mp3_albums)) {
    shuffle($mp3_albums);
}

$cdjsonPath = __DIR__ . "/../web_output/cd_albums.json";
$cd_albums = json_decode(file_get_contents($cdjsonPath), true);

if (is_array($cd_albums)) {
    shuffle($cd_albums);
}

// Decide randomly which section goes first
$sections = ['mp3', 'cd'];
shuffle($sections);
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

<?php foreach ($sections as $section): ?>

    <?php if ($section === 'mp3'): ?>
        <details open>
        <summary><h2 id="MP3">MP3 Collection</h2></summary>
            <div id="mp3" class="media-grid">
            <?php foreach ($mp3_albums as $a): ?>
                <div class="element">
                    <a href="/album?type=mp3&artist=<?php echo urlencode($a['artist']); ?>&album=<?php echo urlencode($a['album']); ?>">                    <?php if ($a["cover"]): ?>
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
        </details>

    <?php else: ?>
        <details open>
        <summary><h2 id="CD">CD Collection</h2></summary>
            <div id="cd" class="media-grid">
            <?php foreach ($cd_albums as $a): ?>
                <div class="element">
                    <a href="/album?type=cd&artist=<?php echo urlencode($a['artist']); ?>&album=<?php echo urlencode($a['album']); ?>">                    <?php if (!empty($a["cover"])): ?>
                            <img src="/web_output/<?php echo htmlspecialchars($a["cover"]); ?>?v=<?php echo filemtime(__DIR__ . "/../web_output/" . $a["cover"]); ?>" loading="lazy">
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
        </details>

    <?php endif; ?>

<?php endforeach; ?>

</body>
</html>