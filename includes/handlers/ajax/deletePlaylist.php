<?php
include("../../config.php");

if (isset($_POST['playlistId'])) {
    // Sanitizar ID como inteiro
    $playlistId = intval($_POST['playlistId']);

    // Prepared statement para deletar playlist
    $stmt = mysqli_prepare($con, "DELETE FROM playlists WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $playlistId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Prepared statement para deletar músicas da playlist
    $stmt = mysqli_prepare($con, "DELETE FROM playlistSongs WHERE playlistId = ?");
    mysqli_stmt_bind_param($stmt, "i", $playlistId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
else {
    echo "PlaylistId was not passed into deletePlaylist.php";
}

?>