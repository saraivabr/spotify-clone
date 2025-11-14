<?php 

class Album {

    private $con, $id, $title, $artistId, $genre, $artworkPath;

    public function __construct($con, $id) {
        $this->con = $con;
        $this->id = intval($id); // Sanitizar ID como inteiro

        // Prepared statement para prevenir SQL Injection
        $stmt = mysqli_prepare($this->con, "SELECT * FROM albums WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $this->id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $album = mysqli_fetch_array($result);
        mysqli_stmt_close($stmt);

        $this->title = $album['title'];
        $this->artistId = intval($album['artist']);
        $this->genre = $album['genre'];
        $this->artworkPath = $album['artworkPath'];

    }

    public function getTitle() {
        // Escape HTML para prevenir XSS
        return htmlspecialchars($this->title, ENT_QUOTES, 'UTF-8');
    }

    public function getArtist() {
        return new Artist($this->con, $this->artistId);
    }

    public function getGenre() {
        // Escape HTML para prevenir XSS
        return htmlspecialchars($this->genre, ENT_QUOTES, 'UTF-8');
    }

    public function getArtworkPath() {
        return $this->artworkPath;
    }

    public function getNumberOfSongs() {
        // Prepared statement para prevenir SQL Injection
        $stmt = mysqli_prepare($this->con, "SELECT id FROM songs WHERE album = ?");
        mysqli_stmt_bind_param($stmt, "i", $this->id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $count = mysqli_stmt_num_rows($stmt);
        mysqli_stmt_close($stmt);

        return $count;
    }

    public function getSongIds() {
        // Prepared statement para prevenir SQL Injection
        $stmt = mysqli_prepare($this->con, "SELECT id FROM songs WHERE album = ? ORDER BY albumOrder ASC");
        mysqli_stmt_bind_param($stmt, "i", $this->id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $array = array();

        while ($row = mysqli_fetch_array($result)) {
            array_push($array, intval($row['id']));
        }

        mysqli_stmt_close($stmt);
        return $array;
    }


}


?>