<?php
    session_start();
    ob_start();

    $timezone = date_default_timezone_set("America/Toronto");

    // Parse DATABASE_URL from Scalingo
    $database_url = getenv('SCALINGO_MYSQL_URL') ?: getenv('DATABASE_URL');

    if ($database_url) {
        $url_parts = parse_url($database_url);
        $db_host = $url_parts['host'];
        $db_user = $url_parts['user'];
        $db_pass = $url_parts['pass'];
        $db_name = ltrim($url_parts['path'], '/');
        $db_port = isset($url_parts['port']) ? $url_parts['port'] : 3306;
    } else {
        // Fallback para desenvolvimento local
        $db_host = "localhost";
        $db_user = "root";
        $db_pass = "";
        $db_name = "spotify";
        $db_port = 3306;
    }

    $con = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);

    if (mysqli_connect_errno()) {
        echo "Failed to connect: " . mysqli_connect_errno();
    }

?>