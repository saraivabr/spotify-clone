<?php
include("../../config.php");

if (isset($_POST['playlistId']) && isset($_POST['songId'])) {

    // Sanitizar IDs como inteiros
    $playlistId = intval($_POST['playlistId']);
    $songId = intval($_POST['songId']);

    // Prepared statement para prevenir SQL Injection
    $stmt = mysqli_prepare($con, "DELETE FROM playlistSongs WHERE playlistId = ? AND songId = ?");
    mysqli_stmt_bind_param($stmt, "ii", $playlistId, $songId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
else {
    echo "PlaylistId or songId was not passed into removeFromPlaylist.php";
}

?>