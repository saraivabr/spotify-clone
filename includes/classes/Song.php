<?php 

class Song {

    private $con, $id, $mysqliData, $title, $artistId, $albumId, $genre, $duration, $path;

    public function __construct($con, $id) {
        $this->con = $con;
        $this->id = intval($id); // Sanitizar ID como inteiro

        // Prepared statement para prevenir SQL Injection
        $stmt = mysqli_prepare($this->con, "SELECT * FROM songs WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $this->id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $this->mysqliData = mysqli_fetch_array($result);
        mysqli_stmt_close($stmt);

        $this->title = $this->mysqliData['title'];
        $this->artistId = intval($this->mysqliData['artist']);
        $this->albumId = intval($this->mysqliData['album']);
        $this->genre = $this->mysqliData['genre'];
        $this->duration = $this->mysqliData['duration'];
        $this->path = $this->mysqliData['path'];
    }

    public function getMysqliData() {
        return $this->mysqliData;
    }

    public function getTitle() {
        // Escape HTML para prevenir XSS
        return htmlspecialchars($this->title, ENT_QUOTES, 'UTF-8');
    }

    public function getId() {
        return $this->id;
    }

    public function getArtist() {
        return new Artist($this->con, $this->artistId);
    }
    public function getAlbum() {
        return new Album($this->con, $this->albumId);
    }

    public function getGenre() {
        // Escape HTML para prevenir XSS
        return htmlspecialchars($this->genre, ENT_QUOTES, 'UTF-8');
    }

    public function getDuration() {
        return $this->duration;
    }

    public function getPath() {
        // Path não precisa de escape, mas validar que é seguro
        return $this->path;
    }


}


?>