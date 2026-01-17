<?php
header("Content-Type: application/xml; charset=UTF-8");

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

<?php
$base = "https://petermacaulay.ca";

/* ---------- STATIC PAGES ---------- */
$staticPages = [
    '/',
    '/blog',
    '/essays',
    '/projects'
];

foreach ($staticPages as $path) {
    echo "<url>
        <loc>{$base}{$path}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>";
}

/* ---------- BLOG POSTS ---------- */
$blogDir = __DIR__ . "/blogposts";
$blogFiles = glob($blogDir . "/*.html");

foreach ($blogFiles as $file) {
    $slug = basename($file, ".html");
    $lastmod = date('Y-m-d', filemtime($file));

    echo "<url>
        <loc>{$base}/blog/{$slug}</loc>
        <lastmod>{$lastmod}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>";
}

/* ---------- ESSAYS ---------- */
$essayDir = __DIR__ . "/essayfolder";
$essayFiles = glob($essayDir . "/*.html");

foreach ($essayFiles as $file) {
    $slug = basename($file, ".html");
    $lastmod = date('Y-m-d', filemtime($file));

    echo "<url>
        <loc>{$base}/essays/{$slug}</loc>
        <lastmod>{$lastmod}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>";
}
?>

</urlset>
