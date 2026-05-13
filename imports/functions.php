<?php
function get_first_div($file, $class) {
    if (!file_exists($file)) {
        return "<p style='color:red;'>File not found: $file</p>";
    }

    $html = file_get_contents($file);

    // This pattern finds the FIRST occurrence of <div class="contentbox"> ... </div>
    // even if it’s wrapped in <a> tags, spans multiple lines, etc.
    $pattern = '/(<a[^>]*>\s*)?<div[^>]*class\s*=\s*["\']\s*' 
                . preg_quote($class, '/') . '\s*["\'][^>]*>.*?<\/div>(\s*<\/a>)?/si';

    if (preg_match($pattern, $html, $match)) {
        return $match[0];
    } else {
        return "<p style='color:red;'>No .$class found in $file</p>";
    }
}
?>

<?php
function get_latest_post_by_internal_date($folder) {

    // Ensure folder ends without trailing slash
    $folder = rtrim($folder, '/');

    // Get all .html files inside folder
    $files = glob("$folder/*.html");
    if (!$files) return null;

    $latestFile = null;
    $latestTimestamp = 0;

    foreach ($files as $path) {

        // Read file into array of lines
        $raw = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (!$raw) continue;

        // We expect date on line 2 (index 1)
        $dateLine = $raw[1] ?? null;
        if (!$dateLine) continue;

        // Try parsing it
        $timestamp = strtotime($dateLine);
        if (!$timestamp) continue;  // skip if invalid date

        if ($timestamp > $latestTimestamp) {
            $latestTimestamp = $timestamp;
            $latestFile = $path;
        }
    }

    return $latestFile;  // returns the path string or null
}
?>

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
            "author" => (string)$gr->author_name,
            "stars" => ((string)$gr->user_rating !== "0")
            ? str_repeat("★", (int)$gr->user_rating)
            : "",
            "date_read" => (string)$gr->user_read_at   // ← add this
        ];
    }

    return $books;
}
?>

<?php
function getCurrentlyReading() {
    $books = fetchShelf("currently-reading");
    return $books;
}
?>

<?php
function getAllMovies() {
    $moviesjsonPath = __DIR__ . "/../web_output/movies.json";
    if (!file_exists($moviesjsonPath)) return [];

    $movies = json_decode(file_get_contents($moviesjsonPath), true);

    if (!$movies) return [];

    // helper
    $normalizeDate = function($date) {
        if (!$date) return "0000-00-00";

        $parts = explode("-", $date);

        $year  = ($parts[0] ?? "0000") === "??" ? "0000" : $parts[0];
        $month = ($parts[1] ?? "00")   === "??" ? "00"   : $parts[1];
        $day   = ($parts[2] ?? "00")   === "??" ? "00"   : $parts[2];

        return "$year-$month-$day";
    };

    // split
    $series = [];
    $standalone = [];

    foreach ($movies as $m) {
        if (!empty($m["series"])) {
            $series[$m["series"]][] = $m;
        } else {
            $standalone[] = $m;
        }
    }

    // sort series internally
    foreach ($series as &$group) {
        usort($group, function($a, $b) {
            return ($a["series_order"] ?? 999) <=> ($b["series_order"] ?? 999);
        });
    }
    unset($group);

    // flatten
    $series_flat = [];
    foreach ($series as $group) {
        foreach ($group as $m) {
            $series_flat[] = $m;
        }
    }

    // combine
    $all_movies = array_merge($standalone, $series_flat);

    // sort by watched date DESC
    usort($all_movies, function($a, $b) use ($normalizeDate) {
        return strcmp(
            $normalizeDate($b["watched"] ?? ""),
            $normalizeDate($a["watched"] ?? "")
        );
    });

    return $all_movies;
}
?>

<?php
function getRecentMovies($limit = 3) {
    $movies = getAllMovies();
    return array_slice($movies, 0, $limit);
}
?>

