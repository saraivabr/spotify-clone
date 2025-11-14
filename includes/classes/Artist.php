<?php 

class Artist {

    private $con, $id;

    public function __construct($con, $id) {
        $this->con = $con;
        $this->id = intval($id); // Sanitizar ID como inteiro
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        // Prepared statement para prevenir SQL Injection
        $stmt = mysqli_prepare($this->con, "SELECT name FROM artists WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $this->id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $artist = mysqli_fetch_array($result);
        mysqli_stmt_close($stmt);

        // Escape HTML para prevenir XSS
        return htmlspecialchars($artist['name'], ENT_QUOTES, 'UTF-8');
    }

    public function getSongIds() {
        // Prepared statement para prevenir SQL Injection
        $stmt = mysqli_prepare($this->con, "SELECT id FROM songs WHERE artist = ? ORDER BY plays ASC");
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