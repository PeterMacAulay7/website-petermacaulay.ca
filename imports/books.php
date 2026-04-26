<?php

require_once __DIR__ . '/functions.php';

$currentBooks = fetchShelf("currently-reading");
$readBooks = fetchShelf("read");
$wanttoreadbooks = fetchShelf("to-read");

usort($readBooks, function($a, $b) {
    $timeA = !empty($a['date_read']) ? strtotime($a['date_read']) : 0;
    $timeB = !empty($b['date_read']) ? strtotime($b['date_read']) : 0;
    return $timeB - $timeA;
});
$wanttoreadbooks = fetchShelf("to-read");

//shuffle($readBooks); // optional

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Books</title>
</head>
<body>

<a class="back-link" href="/library">← Back to Library</a>
<br>
<p>Nav</p>
<a href="#Currently-Reading">Currently Reading</a><br>
<a href="#Read">Read</a><br>
<a href="#Want-To-Read">Want To Read</a><br>

<!-- CURRENTLY READING -->

<div class="shelf-section currently-reading">
    <h2 id = "Currently-Reading">Currently Reading</h2>

    <div class="media-grid">
    <?php foreach ($currentBooks as $b): ?>
        <div class="element">
            <?php if ($b["cover"]): ?>
                <img src="<?php echo htmlspecialchars($b["cover"]); ?>" loading="lazy">
            <?php else: ?>
                <div class="no-cover">No Cover</div>
            <?php endif; ?>

            <div class="info">
                <strong><?php echo htmlspecialchars($b["title"]); ?></strong>
                <span><?php echo htmlspecialchars($b["author"]); ?></span>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</div>


<!-- READ SHELF -->

<div class="shelf-section">
    <h2 id = "Read">Read</h2>

    <div class="media-grid">
    <?php foreach ($readBooks as $b): ?>
        <div class="element">
            <a href="/book?title=<?php echo urlencode($b['title']); ?>">
                <?php if ($b["cover"]): ?>
                    <img src="<?php echo htmlspecialchars($b["cover"]); ?>" loading="lazy">
                <?php else: ?>
                    <div class="no-cover">No Cover</div>
                <?php endif; ?>
            </a>

            <div class="info">
                <strong><?php echo htmlspecialchars($b["title"]); ?></strong>
                <span><?php echo htmlspecialchars($b["author"]); ?></span><br>
                <span>
                    <?php 
                        if (!empty($b["date_read"])) {
                            $timestamp = strtotime($b["date_read"]);
                            echo "Read: " . date("Y-m-d", $timestamp); 
                        }
                    ?>
                </span>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</div>

<!-- TO READ -->

<div class="shelf-section want-to-read">
    <h2 id = "Want-To-Read">Want To Read</h2>

    <div class="media-grid">
    <?php foreach ($wanttoreadbooks as $b): ?>
        <div class="element">
            <?php if ($b["cover"]): ?>
                <img src="<?php echo htmlspecialchars($b["cover"]); ?>" loading="lazy">
            <?php else: ?>
                <div class="no-cover">No Cover</div>
            <?php endif; ?>

            <div class="info">
                <strong><?php echo htmlspecialchars($b["title"]); ?></strong>
                <span><?php echo htmlspecialchars($b["author"]); ?></span>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</div>

</body>
</html>