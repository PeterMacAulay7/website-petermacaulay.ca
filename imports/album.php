<?php
// Load MP3 JSON
$mp3jsonPath = __DIR__ . "/../web_output/mp3_albums.json";
if (!file_exists($mp3jsonPath)) {
    die("mp3_albums.json not found");
}
$mp3_albums = json_decode(file_get_contents($mp3jsonPath), true);
if (!$mp3_albums) {
    die("MP3 JSON failed to load");
}

// Load CD JSON
$cdjsonPath = __DIR__ . "/../web_output/cd_albums.json";
if (!file_exists($cdjsonPath)) {
    die("cd_albums.json not found");
}
$cd_albums = json_decode(file_get_contents($cdjsonPath), true);
if (!$cd_albums) {
    die("CD JSON failed to load");
}

$artist = $_GET['artist'] ?? '';
$album = $_GET['album'] ?? '';

$found = null;
$type = null; // track whether it's mp3 or cd

$type = $_GET['type'] ?? 'mp3'; // default to mp3 if missing
$artist = $_GET['artist'] ?? '';
$album = $_GET['album'] ?? '';

$found = null;

if ($type === 'mp3') {
    foreach ($mp3_albums as $a) {
        if ($a['artist'] === $artist && $a['album'] === $album) {
            $found = $a;
            break;
        }
    }
} elseif ($type === 'cd') {
    foreach ($cd_albums as $a) {
        if ($a['artist'] === $artist && $a['album'] === $album) {
            $found = $a;
            break;
        }
    }
}

if (!$found) {
    die("Album not found.");
}
?>

<a class="back-link" href="/music">← Back to Archive</a>

<div class="media-page">

    <?php
    // Decide which image to use
    if ($type === 'mp3') {
        $image = $found["cover"] ?? null;
    } else {
        $image = $found["back"] ?? null;
    }
    ?>

    <?php if ($image): ?>
        <img class="element-cover-large"
             src="/web_output/<?php echo htmlspecialchars($image); ?>">
    <?php endif; ?>

    <div class="element-details">
        <h1><?php echo htmlspecialchars($found["album"]); ?></h1>
        <h2><?php echo htmlspecialchars($found["artist"]); ?></h2>

        <?php if (!empty($found["tracks"])): ?>
        <ol class="tracklist">
            <?php foreach ($found["tracks"] as $track): ?>
                <li><?php echo htmlspecialchars($track); ?></li>
            <?php endforeach; ?>
        </ol>
        <?php endif; ?>
    </div>
</div>