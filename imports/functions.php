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

