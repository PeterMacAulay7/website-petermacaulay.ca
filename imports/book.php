<?php

$rssUrl = "https://www.goodreads.com/review/list_rss/187027191?shelf=read";
$xml = simplexml_load_file($rssUrl);

if (!$xml) {
    die("Failed to load Goodreads feed.");
}

$title = $_GET['title'] ?? '';
$found = null;

foreach ($xml->channel->item as $item) {

    $namespaces = $item->getNamespaces(true);
    $gr = $item->children($namespaces['gr']);

    if ((string)$item->title === $title) {
        $found = [
            "title" => (string)$item->title,
            "author" => (string)$gr->author_name,
            "cover" => (string)$gr->book_large_image_url,
            "review" => (string)$gr->review_text,
            "link" => (string)$item->link
        ];
        break;
    }
}

if (!$found) {
    die("Book not found.");
}
?>

<a class="back-link" href="/books">← Back to Books</a>

<div class="media-page">

    <?php if ($found["cover"]): ?>
        <img class="book-cover-large" src="<?php echo htmlspecialchars($found["cover"]); ?>">
    <?php endif; ?>

    <div class="element-details">
        <h1><?php echo htmlspecialchars($found["title"]); ?></h1>
        <h2><?php echo htmlspecialchars($found["author"]); ?></h2>

        <div class="review">
            <?php echo nl2br(htmlspecialchars($found["review"])); ?>
        </div>

        <p>
            <a href="<?php echo htmlspecialchars($found["link"]); ?>" target="_blank">
                View on Goodreads →
            </a>
        </p>
    </div>
</div>