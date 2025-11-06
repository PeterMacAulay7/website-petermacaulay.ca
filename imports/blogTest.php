<?php

/* $jsonStr = file_get_contents('blog/blog.json'); */
/* $json = json_decode($jsonStr, true); */
if (array_key_exists('entry', $_GET)) { // if blog post specified
    $found = false;
    foreach ($blogData as $blogEntry) {
        $entry = str_replace(" ", "-", strtolower($blogEntry['title']));
        if ($entry == $_GET['entry']) {
            $found = true;
            $content = file_get_contents("blog/entries/{$entry}.html");
            if (array_key_exists("cat", $_GET)) {
                printBackCopyRssButtons("/?nav=blog&cat=" . $_GET["cat"], true, true);
            } else {
                printBackCopyRssButtons("/?nav=blog", true, true);
            }
            echo "
              <br><p><i>" . $blogEntry['date'] . "</i></p>
              <h2>" . $blogEntry['title'] . "</h2>
              <h4>" . $blogEntry['subheading'] . "</h4><hr><br>
              $content<br>
              <hr><p><b>Categories</b>: ";
            foreach ($blogEntry['categories'] as $category) {
                echo "<a href='/?nav=blog&cat=$category'>$category</a> ";
            }
            echo "</p><script src='js/copy-url.js' defer></script>";
            break;
        }
    }
    if ($found == false) {
        printBackCopyRssButtons("/?nav=blog", false, true);
        xNotFound("Post");
    }
} else { // post not specified
    echo "<h1>Blog...</h1><br>
      <p>This is going to be a complete mixed bag of topics, please enjoy lol</p><br>";
    $categories = getCategories($blogData);
    $getCatUrlQuestionMark = "";
    $getCatUrlAmpersand = "";
    $allPosts = "";
    if (array_key_exists("cat", $_GET)) { // category specified
        $found = false;
        foreach ($blogData as $blogEntry) {
            if (in_array($_GET["cat"], $blogEntry["categories"])) {
                $found = true;
                break;
            }
        }
        if ($found == true) { // category exists
            $category = $_GET["cat"];
            $getCatUrlQuestionMark = "?cat=$category";
            $getCatUrlAmpersand = "&cat=$category";
            $showCategories = true;
            $arrow = "up";
            $entriesToPrint = [];
            $allPosts = "<a href='/?nav=blog'>
                <img src='images/graphics/gruvbox/back.webp'> 
                <b>Back to all posts</b>
            </a> | ";
            foreach ($blogData as $blogEntry) {
                if (in_array($category, $blogEntry["categories"])) {
                    $entriesToPrint[] = $blogEntry;
                }
            }
        } else { // category doesn't exist
            xNotFound("Category <i>" . $_GET["cat"] . "</i>");
        }
    } else {
        $category = "All Posts";
        $showCategories = false;
        $arrow = "down";
        $entriesToPrint = $blogData;
    }
    // print blog index page
    echo "<h2>$category</h2><br> 
    <p>
        $allPosts
        <a href='/rss.php$getCatUrlQuestionMark'>
            <img src='images/graphics/gruvbox/rss2.webp'>
            <b>RSS feed for <i>$category</i></b>
        </a> | 
        <a href='javascript:;' id='categories-button'>
          <b>Categories</b> <img src='images/graphics/gruvbox/$arrow.webp'>
        </a>
    </p>";
    printCategories($categories, $showCategories);
    echo "<ul>";
    foreach ($entriesToPrint as $blogEntry) {
        $entry = str_replace(" ", "-", strtolower($blogEntry['title']));
        $title = $blogEntry["title"];
        $date = $blogEntry["date"];
        $found = true;
        echo "<li>
            <a href='/?nav=blog&entry=$entry$getCatUrlAmpersand'>
                <b>$title</b> - $date
            </a>
        </li>";
    }
    echo "</ul><script src='js/categories.js' defer></script>";
    //echo "<img src='images/random-images/gruvbox/shapes.webp'>";
}