<div class="outter">
<?php
// blog.php

$blogFolder = __DIR__ . "/../blogposts";
$files = glob($blogFolder . "/*.html");
$posts = [];

/* ---------------------------
   Date parsing (shared idea)
---------------------------- */
function parse_date_to_ts($date, $fallbackPath = null) {
    $date = trim($date);
    if ($date !== '') {
        $ts = @strtotime($date);
        if ($ts !== false && $ts !== -1) {
            return $ts;
        }
    }

    // fallback: file modification time
    if ($fallbackPath && file_exists($fallbackPath)) {
        $mt = @filemtime($fallbackPath);
        if ($mt) return $mt;
    }

    return time();
}

/* ---------------------------
   Load posts
---------------------------- */
foreach ($files as $path) {
    $filename = basename($path, ".html");
    $raw = @file($path, FILE_IGNORE_NEW_LINES);
    if ($raw === false) continue;

    // Title and date from first two lines
    $title = $raw[0] ?? ucwords(str_replace(['-','_'], ' ', $filename));
    $date  = $raw[1] ?? '';

    $timestamp = parse_date_to_ts($date, $path);

    // Everything after line 2 is content
    $fullContent = implode("\n", array_slice($raw, 2));

    // Extract preview (first .contentbox)
    $previewBox = "";
    if (preg_match(
        '/<div[^>]*class=["\'][^"\']*\bcontentbox\b[^"\']*["\'][^>]*>.*?<\/div>/si',
        $fullContent,
        $match
    )) {
        $previewBox = $match[0];
    }

    $posts[] = [
        "slug"      => $filename,
        "title"     => trim($title),
        "date"      => trim($date) ?: date("Y-m-d", $timestamp),
        "timestamp" => $timestamp,
        "content"   => $fullContent,
        "preview"   => $previewBox,
        "path"      => $path
    ];
}

/* ---------------------------
   Sort newest → oldest
---------------------------- */
usort($posts, function ($a, $b) {
    return $b['timestamp'] <=> $a['timestamp'];
});

/* ---------------------------
   Single post view
---------------------------- */
if (isset($_GET["page"])) {
    $slug = $_GET["page"];
    foreach ($posts as $post) {
        if ($post["slug"] === $slug) {
            echo "<a href='/blog'>&larr; Back to all posts</a>";
            echo "<h2>" . htmlspecialchars($post["title"]) . "</h2>";
            echo "<p><i>" . htmlspecialchars($post["date"]) . "</i></p>";
            echo $post["content"];
            return;
        }
    }

    echo "<p style='color:red;'>Post not found.</p>";
    return;
}
?>
</div>

<h2>Blog Posts</h2>

<div class="outter">
<?php foreach ($posts as $post): ?>
    <a href="/blog/<?php echo urlencode($post['slug']); ?>" class="post-link">
        <h2><?php echo htmlspecialchars($post['title']); ?></h2>
        <p><i><?php echo htmlspecialchars($post['date']); ?></i></p>

        <?php
        if (!empty($post['preview'])) {
            echo $post['preview'];
        } else {
            echo "<div class='contentbox'><p>No preview available.</p></div>";
        }
        ?>
    </a>
<?php endforeach; ?>
</div>
