
<div class = "outter">
<?php
// essays.php - content-only for inclusion in index.php

$essayfolder = __DIR__ . "/../essayfolder";
$files = glob($essayfolder . "/*.html");
$posts = [];

if (!function_exists('get_dom_outer_html')) {
    function get_dom_outer_html($node) {
        $doc = new DOMDocument();
        $doc->appendChild($doc->importNode($node, true));
        return $doc->saveHTML();
    }
}

function try_parse_date_to_ts($candidate, $pathFallback = null) {
    $candidate = trim($candidate);
    if ($candidate === '') return false;

    // Try native strtotime first
    $ts = @strtotime($candidate);
    if ($ts !== false && $ts !== -1) return $ts;

    // Try explicit formats common in your content
    $formats = [
        'd/m/Y', 'd-m-Y', 'Y-m-d', 'j F Y', 'j M Y', 'F j, Y', 'M j, Y',
        'd M Y', 'd F Y', 'm/d/Y', 'n/j/Y', 'Y/m/d'
    ];
    foreach ($formats as $fmt) {
        $d = DateTime::createFromFormat($fmt, $candidate);
        if ($d && $d->getTimestamp() > 0) return $d->getTimestamp();
    }

    // Try to extract a dd/mm/yyyy or dd-mm-yyyy pattern
    if (preg_match('/\b(\d{1,2})[\/-](\d{1,2})[\/-](\d{4})\b/', $candidate, $m)) {
        $dstr = sprintf('%02d-%02d-%04d', $m[1], $m[2], $m[3]);
        $d = DateTime::createFromFormat('d-m-Y', $dstr);
        if ($d) return $d->getTimestamp();
    }

    // Try to find a year and parse a small snippet around it
    if (preg_match('/(19|20)\d{2}/', $candidate, $ym)) {
        $pos = strpos($candidate, $ym[0]);
        if ($pos !== false) {
            $snippet = substr($candidate, max(0, $pos - 30), 60);
            $ts2 = @strtotime($snippet);
            if ($ts2 !== false && $ts2 !== -1) return $ts2;
        }
    }

    // Fallback to file mtime if available
    if ($pathFallback && file_exists($pathFallback)) {
        $mt = @filemtime($pathFallback);
        if ($mt) return $mt;
    }

    return false;
}

// Build posts list
foreach ($files as $path) {
    $filename = basename($path, ".html");
    $html = @file_get_contents($path);
    if ($html === false) continue;

    // Load DOM for reliable extraction
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html); // keep encoding sane
    libxml_clear_errors();
    $xpath = new DOMXPath($dom);

    // Title detection: try h1, h2, title, then first plain top line, else friendly filename
    $title = $filename;
    if ($node = $xpath->query('//h1')->item(0)) {
        $title = trim($node->textContent);
    } elseif ($node = $xpath->query('//h2')->item(0)) {
        $title = trim($node->textContent);
    } elseif ($node = $xpath->query('//title')->item(0)) {
        $title = trim($node->textContent);
    } else {
        // check top-of-file plain lines
        $lines = preg_split("/\r\n|\n|\r/", $html, 4);
        if (isset($lines[0]) && trim($lines[0]) !== '' && $lines[0][0] !== '<') {
            $title = trim(strip_tags($lines[0]));
        } else {
            $title = ucwords(str_replace(['-','_'], ' ', $filename));
        }
    }

    // Date detection: several heuristics
    $dateCandidate = null;
    // 1) second top line if plain text
    $lines = preg_split("/\r\n|\n|\r/", $html, 4);
    if (isset($lines[1]) && trim($lines[1]) !== '' && $lines[1][0] !== '<') {
        $dateCandidate = trim(strip_tags($lines[1]));
    }

    // 2) time[datetime] or time
    if (!$dateCandidate) {
        $time = $xpath->query('//time[@datetime]')->item(0);
        if ($time) $dateCandidate = trim($time->textContent ?: $time->getAttribute('datetime'));
    }
    if (!$dateCandidate) {
        $time = $xpath->query('//time')->item(0);
        if ($time) $dateCandidate = trim($time->textContent);
    }

    // 3) meta tags
    if (!$dateCandidate) {
        $meta = $xpath->query('//meta[@name="date" or @property="article:published_time"]')->item(0);
        if ($meta) $dateCandidate = trim($meta->getAttribute('content'));
    }

    // 4) <p class="date"> or <p id="date">
    if (!$dateCandidate) {
        $pdate = $xpath->query('//p[contains(@class,"date") or @id="date"]')->item(0);
        if ($pdate) $dateCandidate = trim($pdate->textContent);
    }

    // 5) first <p> containing a year
    if (!$dateCandidate) {
        $ps = $xpath->query('//p');
        foreach ($ps as $p) {
            if (preg_match('/\b(19|20)\d{2}\b/', $p->textContent)) {
                $dateCandidate = trim($p->textContent);
                break;
            }
        }
    }

    // Parse to timestamp (robust)
    $timestamp = false;
    if (!empty($dateCandidate)) {
        $timestamp = try_parse_date_to_ts($dateCandidate, $path);
    }
    if ($timestamp === false) {
        $timestamp = @filemtime($path) ?: time();
    }

    // PREVIEW extraction: use DOM to find the first element whose class list contains 'contentbox'
    $previewBox = "";
    $nodes = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' contentbox ')]");
    if ($nodes && $nodes->length > 0) {
        // take first matching node and get its outer HTML
        $first = $nodes->item(0);
        $previewBox = get_dom_outer_html($first);
    } else {
        // Fallback: try get_first_div() if available and returns a legitimate div
        if (function_exists('get_first_div')) {
            $maybe = get_first_div($path, 'contentbox'); // expects file path
            if (stripos($maybe, '<div') !== false && stripos($maybe, 'contentbox') !== false) {
                $previewBox = $maybe;
            }
        }
    }

    // If still empty, create a tiny generated preview from first 1-2 <p> nodes (not the entire body)
    if (empty($previewBox)) {
        $pNodes = $xpath->query('//p');
        $previewParts = [];
        $max = min(2, $pNodes->length);
        for ($i = 0; $i < $max; $i++) {
            $previewParts[] = $dom->saveHTML($pNodes->item($i));
        }
        if (!empty($previewParts)) {
            $previewBox = '<div class="contentbox">' . implode("\n", $previewParts) . '</div>';
        }
    }

    $posts[] = [
        'slug'      => $filename,
        'title'     => $title,
        'date'      => $dateCandidate ?: date('Y-m-d', $timestamp),
        'timestamp' => $timestamp,
        'content'   => $html,
        'preview'   => $previewBox,
        'path'      => $path
    ];
}

// Sort by timestamp, newest first
usort($posts, function($a, $b) {
    return $b['timestamp'] <=> $a['timestamp'];
});

// SINGLE POST view: look up by slug within indexed $posts
if (isset($_GET['page'])) {
    $slug = $_GET['page'];
    foreach ($posts as $post) {
        if ($post['slug'] === $slug) {
            echo "<a href='?nav=essays'>&larr; Back to all essays</a>";
            echo "<h2>" . htmlspecialchars($post['title']) . "</h2>";
            echo "<p><i>" . htmlspecialchars($post['date']) . "</i></p>";
            echo $post['content']; // raw html
            return;
        }
    }
    echo "<p style='color:red;'>Essay not found.</p>";
    return;
}
// LIST view
?>
</div>
<div class="outter">
<?php foreach ($posts as $post): ?>
    <a href="?nav=essays&page=<?php echo urlencode($post['slug']); ?>" class="post-link">
        <h2><?php echo htmlspecialchars($post['title']); ?></h2>
        <p><i><?php echo htmlspecialchars($post['date']); ?></i></p>

        <?php
        if (!empty($post['preview'])) {
            echo $post['preview']; // already contains contentbox wrapper
        } else {
            echo "<div class='contentbox'><p>No preview available.</p></div>";
        }
        ?>
    </a>
<?php endforeach; ?>
</div>
