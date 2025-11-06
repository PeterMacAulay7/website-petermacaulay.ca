<?php
function printRandomImage()
{
    $imageDir = "images/random-images";
    $images = scandir($imageDir);
    $images = array_slice($images, 2);
    echo "<p><img loading='lazy' class='center' src='" . $imageDir . "/" . $images[array_rand($images)] . "'></p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404</title>
</head>
<body>
    <h1>404 - Page Not Found</h1>
    <h2>The page you're looking for doesn't exist</h2>
    <p>Sorry about that! Please use the navigation menu to find what you're looking for.</p>
    <?php printRandomImage(); ?>
</body>
</html>