<?php

$jsonPath = __DIR__ . "/../web_output/albums.json";

if (!file_exists($jsonPath)) {
    die("albums.json not found");
}

$albums = json_decode(file_get_contents($jsonPath), true);

if (!$albums) {
    die("JSON failed to load");
}

$artist = $_GET['artist'] ?? '';
$album = $_GET['album'] ?? '';

$found = null;

foreach ($albums as $a) {
    if ($a['artist'] === $artist && $a['album'] === $album) {
        $found = $a;
        break;
    }
}

if (!$found) {
    die("Album not found.");
}
?>

<a class="back-link" href="/music">← Back to Archive</a>

<div class="media-page">
    <?php if ($found["cover"]): ?>
        <img class="element-cover-large" src="/web_output/<?php echo htmlspecialchars($found["cover"]); ?>">
    <?php endif; ?>

    <div class="element-details">
        <h1><?php echo htmlspecialchars($found["album"]); ?></h1>
        <h2><?php echo htmlspecialchars($found["artist"]); ?></h2>

        <ol class="tracklist">
            <?php foreach ($found["tracks"] as $track): ?>
                <li><?php echo htmlspecialchars($track); ?></li>
            <?php endforeach; ?>
        </ol>
    </div>
</div>

