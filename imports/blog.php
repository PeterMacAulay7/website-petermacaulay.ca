<?php
$blogFolder = __DIR__ . "/../blogposts";

// read all .html blog post files
$files = glob($blogFolder . "/*.html");

// extract structured information for each post
$posts = [];

foreach ($files as $path) {
    $filename = basename($path, ".html");
    $raw = file($path, FILE_IGNORE_NEW_LINES);

    $title = $raw[0] ?? $filename;
    $date  = $raw[1] ?? "Unknown date";

    // everything after line 2 is the full content
    $fullContent = implode("\n", array_slice($raw, 2));

    // extract the preview (first contentbox)
    $previewBox = "";
    if (preg_match('/<div[^>]*class=["\']contentbox["\'][^>]*>.*?<\/div>/si', $fullContent, $match)) {
        $previewBox = $match[0];
    }

    $posts[$filename] = [
        "slug"     => $filename,
        "title"    => $title,
        "date"     => $date,
        "content"  => $fullContent,
        "preview"  => $previewBox
    ];
}

// serve a single post if ?page=slug
if (isset($_GET["page"]) && isset($posts[$_GET["page"]])) {
    $post = $posts[$_GET["page"]];
    echo "<a href='?nav=blog'>&larr; Back to all posts</a>";
    echo "<h2>{$post['title']}</h2>";
    echo "<p><i>{$post['date']}</i></p>";
    echo $post["content"];
    return;
}
?>

<h2>Blog Posts</h2>

<?php foreach ($posts as $post): ?>
    <a href="?nav=blog&page=<?php echo $post['slug']; ?>" class="post-link">
        <h2><?php echo htmlspecialchars($post['title']); ?></h2>
        <p><i><?php echo htmlspecialchars($post['date']); ?></i></p>
        <div class="contentbox">
            <?php
            // show preview HTML if exists
            echo $post["preview"]
                ? $post["preview"]
                : "<p>No preview available.</p>";
            ?>
        </div>
    </a>
<?php endforeach; ?>
