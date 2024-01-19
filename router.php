<?php

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

if (file_exists(__DIR__ . $path)) {
    return false; // serve the requested file
} else {
    // handle other requests, for instance:
    include "index.php";
}
