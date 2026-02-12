<?php
$jsonPath = __DIR__ . "/../web_output/albums.json";
$albums = json_decode(file_get_contents($jsonPath), true);

// Randomize order each page load
if (is_array($albums)) {
    shuffle($albums);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Music Archive</title>
</head>
<body>

<div class="album-grid">
<?php foreach ($albums as $a): ?>
    <div class="album">
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
