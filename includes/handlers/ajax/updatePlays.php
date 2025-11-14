<?php

include("../../config.php");

if (isset($_POST['songId'])) {
    // Sanitizar ID como inteiro
    $songId = intval($_POST['songId']);

    // Prepared statement para prevenir SQL Injection
    $stmt = mysqli_prepare($con, "UPDATE songs SET plays = plays + 1 WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $songId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

?>