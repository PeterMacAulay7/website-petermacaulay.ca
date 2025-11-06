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
