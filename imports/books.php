<?php

function fetchShelf($shelf) {
    $rssUrl = "https://www.goodreads.com/review/list_rss/187027191?shelf=" 
          . urlencode($shelf) 
          . "&nocache=" . time();

    $xml = simplexml_load_file($rssUrl);
    if (!$xml) return [];

    $books = [];

    foreach ($xml->channel->item as $item) {

        $namespaces = $item->getNamespaces(true);
        $gr = $item->children($namespaces['gr']);

        $books[] = [
            "title" => (string)$item->title,
            "link" => (string)$item->link,
            "cover" => (string)$gr->book_large_image_url,
            "review" => (string)$gr->review_text,
            "author" => (string)$gr->author_name
        ];
    }

    return $books;
}

$currentBooks = fetchShelf("currently-reading");
$readBooks = fetchShelf("read");
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


<!-- CURRENTLY READING -->

<div class="shelf-section currently-reading">
    <h2>Currently Reading</h2>

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
    <h2>Read</h2>

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
                <span><?php echo htmlspecialchars($b["author"]); ?></span>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</div>

<!-- TO READ -->

<div class="shelf-section want-to-read">
    <h2>Want To Read</h2>

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