<?php
include("../../config.php");

if (isset($_POST['playlistId']) && isset($_POST['songId'])) {

    // Sanitizar IDs como inteiros
    $playlistId = intval($_POST['playlistId']);
    $songId = intval($_POST['songId']);

    // Prepared statement para obter ordem
    $stmt = mysqli_prepare($con, "SELECT IFNULL(MAX(playlistOrder) + 1, 1) as playlistOrder FROM playlistSongs WHERE playlistId = ?");
    mysqli_stmt_bind_param($stmt, "i", $playlistId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);
    $order = intval($row['playlistOrder']);
    mysqli_stmt_close($stmt);

    // Prepared statement para inserir música
    $stmt = mysqli_prepare($con, "INSERT INTO playlistSongs VALUES('', ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iii", $songId, $playlistId, $order);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
else {
    echo "PlaylistId or songId was not passed into AddtoPlaylist.php";
}

?>