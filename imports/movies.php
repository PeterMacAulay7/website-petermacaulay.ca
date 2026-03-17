
<?php

$moviesjsonPath = __DIR__ . "/../web_output/movies.json";
$movies = json_decode(file_get_contents($moviesjsonPath), true);

/* ---------- helpers ---------- */

function normalizeDate($date) {

    if (!$date) return "0000-00-00";

    $parts = explode("-", $date);

    $year  = ($parts[0] ?? "0000") === "??" ? "0000" : $parts[0];
    $month = ($parts[1] ?? "00")   === "??" ? "00"   : $parts[1];
    $day   = ($parts[2] ?? "00")   === "??" ? "00"   : $parts[2];

    return "$year-$month-$day";
}

/* ---------- split movies ---------- */

$series = [];
$standalone = [];

foreach ($movies as $m) {

    if (!empty($m["series"])) {

        $name = $m["series"];

        if (!isset($series[$name])) {
            $series[$name] = [];
        }

        $series[$name][] = $m;

    } else {

        $standalone[] = $m;

    }

}

/* ---------- sort series internally ---------- */

foreach ($series as &$group) {

    usort($group, function($a, $b) {

        return ($a["series_order"] ?? 999) <=> ($b["series_order"] ?? 999);

    });

}
unset($group);

/* ---------- flatten series ---------- */

$series_flat = [];

foreach ($series as $group) {
    foreach ($group as $m) {
        $series_flat[] = $m;
    }
}

/* ---------- combine ---------- */

$all_movies = array_merge($standalone, $series_flat);

/* ---------- sort by watched date ---------- */

usort($all_movies, function($a, $b) {

    return strcmp(
        normalizeDate($b["watched"] ?? ""),
        normalizeDate($a["watched"] ?? "")
    );

});

/* ---------- extract top 10 ---------- */

$top10 = [];

foreach ($all_movies as $m) {
    if (!empty($m["top10"])) {
        $top10[] = $m;
    }
}

$top10 = array_slice($top10, 0, 10);

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Movie Archive</title>
</head>

<body>

<a class="back-link" href="/library">← Back to Library</a>
<br>

<p>This is a collection of movies I've watched throughout my life. It is not a conclusive collection. I have so far just added a bunch that I remember watching, and some favourites. While I'm not exactly a movie expert, I think they've had a special place in my life and I'm excited to get back into watching them more often.</p>

<p>I don't have the rating system down yet. I'm not the biggest rating fan, but I feel like I might distinguish some as liking them more, or if I really don't like it I'll put that up there. For now it's up to you I suppose if you want to make assumptions about which are which. You are also free to just peruse and please contact me if you want to say anything about anything.</p>

<p>I will say that these movies aren't all in my possession in some way like the other sections of the library. If you're curious about any of them, I may have a downloaded copy or a physical copy, but it's not as likely as music or books.</p>


<!-- TOP 10 -->

<details open>
<summary><h2>Top 10 Movies</h2></summary>

<div class="media-grid">

<?php foreach ($top10 as $a): ?>

<div class="element">

<?php if (!empty($a["poster"])): ?>

<img
src="/web_output/<?php echo htmlspecialchars($a["poster"]); ?>?v=<?php echo filemtime("web_output/" . $a["poster"]); ?>"
loading="lazy"
alt="<?php echo htmlspecialchars($a["title"]); ?>"
>

<?php else: ?>

<div class="no-poster">No poster</div>

<?php endif; ?>

<div class="info">
<strong><?php echo htmlspecialchars($a["title"]); ?></strong>
<?php echo htmlspecialchars("- " . $a["year"]); ?><br>
<span><?php echo htmlspecialchars($a["Director"]); ?></span>
</div>

</div>

<?php endforeach; ?>

</div>
</details>


<!-- FULL COLLECTION -->

<details open>
<summary><h2 id="movies">Movies I've Watched</h2></summary>

<div id="movies" class="media-grid">

<?php foreach ($all_movies as $a): ?>

<div class="element">

<?php if (!empty($a["poster"])): ?>

<img
src="/web_output/<?php echo htmlspecialchars($a["poster"]); ?>?v=<?php echo filemtime("web_output/" . $a["poster"]); ?>"
loading="lazy"
alt="<?php echo htmlspecialchars($a["title"]); ?>"
>

<?php else: ?>

<div class="no-poster">No poster</div>

<?php endif; ?>

<div class="info">
<strong><?php echo htmlspecialchars($a["title"]); ?></strong>
<?php echo htmlspecialchars("- " . $a["year"]); ?><br>
<span><?php echo htmlspecialchars($a["Director"]); ?></span><br>
<span><?php echo htmlspecialchars("Watched: " . ($a["watched"] ?? "Unknown")); ?></span><br>
<span><?php echo htmlspecialchars("Feels: " . ($a["feels"] ?? "Not Rated")); ?></span>

</div>

</div>

<?php endforeach; ?>

</div>

</details>

</body>
</html>
