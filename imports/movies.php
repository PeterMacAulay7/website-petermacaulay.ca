<?php
$moviesjsonPath = __DIR__ . "/../web_output/movies.json";
$movies = json_decode(file_get_contents($moviesjsonPath), true);

$standalone = [];
$series_groups = [];

foreach ($movies as $m) {

    if (!empty($m["series"])) {

        $series = $m["series"];

        if (!isset($series_groups[$series])) {
            $series_groups[$series] = [];
        }

        $series_groups[$series][] = $m;

    } else {
        $standalone[] = $m;
    }
}

# shuffle standalone movies
shuffle($standalone);

# sort movies inside each series
foreach ($series_groups as &$group) {

    usort($group, function ($a, $b) {

        $a_order = $a["series_order"] ?? 0;
        $b_order = $b["series_order"] ?? 0;

        return $a_order <=> $b_order;
    });
}

# combine everything back together
$movies = $standalone;

foreach ($series_groups as $group) {
    foreach ($group as $m) {
        $movies[] = $m;
    }
}

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

<details open>
    <summary><h2 id="movies">Movies I've Watched</h2></summary>
    <p>This is a collection of movies I've watched throughout my life. It is not a conclusive collection. I have so far just added some of my favourites and some that I've watched recently.</p>
    <p>I have plans to distinguish between favourites and recents, or just to display the date watched, or something like that but for now it's up to you I suppose if you want to make assumptions about which are which. You are also free to just peruse and please contact me if you want to say anything about anything.</p>
    <p>I will say that these movies aren't all in my possession in some way like the other sections of the library. If you're curious about any of them, I may have a downloaded copy or a physical copy, but it's not as likely as music or books</p>

    <div id="movies" class="media-grid">
    <?php foreach ($movies as $a): ?>

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
                <span><?php echo htmlspecialchars("Watched: " . $a["watched"]); ?></span>
            </div>

        </div>

    <?php endforeach; ?>
    </div>
</details>

</body>
</html>