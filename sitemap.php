<?php
    require_once("config/config.php");
    include("includes/classes/Convert.php");

    $convert = new Convert($con);

    $base_url = "https://filmove.tv/";

    header("Content-Type: application/xml; charset=utf-8");

    echo '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL;

    echo '<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="https://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="https://www.sitemaps.org/schemas/sitemap/0.9 https://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . PHP_EOL;

    echo '<url>

            <loc>'.$base_url.'</loc>

            <lastmod>'.date("Y-m-d").'</lastmod>

            <changefreq>daily</changefreq>

        </url>';

    echo '<url>

        <loc>'.$base_url.'darmowe-filmy</loc>

        <lastmod>'.date("Y-m-d").'</lastmod>

        <changefreq>daily</changefreq>

    </url>';

    echo '<url>

        <loc>'.$base_url.'darmowe-seriale</loc>

        <lastmod>'.date("Y-m-d").'</lastmod>

        <changefreq>daily</changefreq>

    </url>';

    echo '<url>

        <loc>'.$base_url.'szukaj-darmowy-film</loc>

        <lastmod>'.date("Y-m-d").'</lastmod>

        <changefreq>daily</changefreq>

    </url>';

    $result = mysqli_query($con, "SELECT * FROM video ORDER BY uploadDate DESC");
    
    while($row = mysqli_fetch_array($result)) {
        echo '<url>' . PHP_EOL;
        echo '<loc>'.$base_url.$convert->getVideoHref($row['id']).'</loc>' . PHP_EOL;
        echo '<changefreq>daily</changefreq>' . PHP_EOL;
        echo '<lastmod>'.date("Y-m-d").'</lastmod>' . PHP_EOL;
        echo '</url>' . PHP_EOL;
    }

    $result = mysqli_query($con, "SELECT * FROM categories");

    while($row = mysqli_fetch_array($result)) {
        echo '<url>' . PHP_EOL;
        echo '<loc>'.$base_url.$convert->getCategoryHref($row['id']).'</loc>' . PHP_EOL;
        echo '<changefreq>daily</changefreq>' . PHP_EOL;
        echo '<lastmod>'.date("Y-m-d").'</lastmod>' . PHP_EOL;
        echo '</url>' . PHP_EOL;
    }

    $result = mysqli_query($con, "SELECT * FROM tags");

    while($row = mysqli_fetch_array($result)) {
        echo '<url>' . PHP_EOL;
        echo '<loc>'.$base_url.$convert->getTagHref($row['id']).'</loc>' . PHP_EOL;
        echo '<changefreq>daily</changefreq>' . PHP_EOL;
        echo '<lastmod>'.date("Y-m-d").'</lastmod>' . PHP_EOL;
        echo '</url>' . PHP_EOL;
    }

    echo '</urlset>' . PHP_EOL;
?>