<?php 

class User {

    private $con, $username;

    public function __construct($con, $username) {
        $this->con = $con;
        $this->username = $username;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getFirstAndLastName() {
        // Prepared statement para prevenir SQL Injection
        $stmt = mysqli_prepare($this->con, "SELECT concat(firstName, ' ', lastName) as 'name' FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $this->username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result);
        mysqli_stmt_close($stmt);

        // Escape HTML para prevenir XSS
        return htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
    }

    public function getEmail() {
        // Prepared statement para prevenir SQL Injection
        $stmt = mysqli_prepare($this->con, "SELECT email FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $this->username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result);
        mysqli_stmt_close($stmt);

        // Escape HTML para prevenir XSS
        return htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8');
    }

}

?>