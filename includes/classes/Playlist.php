<?php 

class Playlist {

    private $con, $id, $name, $owner;

    public function __construct($con, $data) {

        if(!is_array($data)) {
            // Data is an id: Usar prepared statement para prevenir SQL Injection
            $id = intval($data); // Sanitizar ID como inteiro
            $stmt = mysqli_prepare($con, "SELECT * FROM playlists WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $data = mysqli_fetch_array($result);
            mysqli_stmt_close($stmt);
        }

        $this->con = $con;
        $this->id = intval($data['id']);
        $this->name = $data['name'];
        $this->owner = $data['owner'];
    }
    
    public function getId() {
        return $this->id;
    }
    public function getName() {
        // Escape HTML para prevenir XSS
        return htmlspecialchars($this->name, ENT_QUOTES, 'UTF-8');
    }

    public function getOwner() {
        return $this->owner;
    }

    public function getNumberOfSongs() {
        // Prepared statement para prevenir SQL Injection
        $stmt = mysqli_prepare($this->con, "SELECT songId FROM playlistSongs WHERE playlistId = ?");
        mysqli_stmt_bind_param($stmt, "i", $this->id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $count = mysqli_stmt_num_rows($stmt);
        mysqli_stmt_close($stmt);

        return $count;
    }

    public function getSongIds() {
        // Prepared statement para prevenir SQL Injection
        $stmt = mysqli_prepare($this->con, "SELECT songId FROM playlistSongs WHERE playlistId = ? ORDER BY playlistOrder ASC");
        mysqli_stmt_bind_param($stmt, "i", $this->id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $array = array();

        while ($row = mysqli_fetch_array($result)) {
            array_push($array, intval($row['songId']));
        }

        mysqli_stmt_close($stmt);
        return $array;
    }

    public static function getPlaylistsDropdown($con, $username) {
        $dropdown = '<select class="item playlist">
                        <option value="">Adicionar à Playlist</option>';

        // Prepared statement para prevenir SQL Injection
        $stmt = mysqli_prepare($con, "SELECT id, name FROM playlists WHERE owner = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_array($result)) {
            $id = intval($row['id']);
            // Escape HTML para prevenir XSS
            $name = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');

            $dropdown = $dropdown . "<option value='$id'>$name</option>";
        }

        mysqli_stmt_close($stmt);
        return $dropdown . "</select>";
    }

}

?>