<?php
include("../../config.php");

if (isset($_POST['name']) && isset($_POST['username'])) {

    // Sanitizar entradas
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $date = date("Y-m-d");

    // Prepared statement para prevenir SQL Injection
    $stmt = mysqli_prepare($con, "INSERT INTO playlists VALUES('', ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $name, $username, $date);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
else {
    echo "Parâmetros de nome ou usuário não foram enviados";
}

?>