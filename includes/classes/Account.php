<?php 

class Account {

    private $errorArray, $con;

    public function __construct($con) {
        $this->con = $con;
        $this->errorArray = array();
    }

    public function login($un, $pw) {
        // Prepared statement para prevenir SQL Injection
        $stmt = mysqli_prepare($this->con, "SELECT password FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $un);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($result)) {
            // Usar password_verify para verificar hash seguro
            if(password_verify($pw, $row['password'])) {
                mysqli_stmt_close($stmt);
                return true;
            }
        }

        mysqli_stmt_close($stmt);
        array_push($this->errorArray, Constants::$loginFailed);
        return false;
    }
    
    public function register($un, $fn, $ln, $em, $em2, $pw, $pw2) {
        $this->validateUsername($un);
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateEmails($em, $em2);
        $this->validatePasswords($pw, $pw2);

        if (empty($this->errorArray)) {
            //Insert into db
            return $this->insertUserDetails($un, $fn, $ln, $em, $pw);
        }
        else {
            return false;
        }
    }

    public function getError($error) {
        if (!in_array($error, $this->errorArray)) {
            $error = "";
        }
        // Escape HTML para prevenir XSS
        return "<span class='errorMessage'>" . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . "</span>";
    }

    private function insertUserDetails($un, $fn, $ln, $em, $pw) {
        // Usar password_hash em vez de MD5
        $hashedPw = password_hash($pw, PASSWORD_DEFAULT);
        $profilePic = "assets/images/profile-pics/head_emerald.png";
        $date = date("Y-m-d");

        // Prepared statement para prevenir SQL Injection
        // Não incluir id (AUTO_INCREMENT) na query
        $stmt = mysqli_prepare($this->con, "INSERT INTO users (username, firstName, lastName, email, password, signUpDate, profilePic) VALUES (?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssssss", $un, $fn, $ln, $em, $hashedPw, $date, $profilePic);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $result;
    }
    
    private function validateUsername($un) {
        if (strlen($un) > 25 || strlen($un) < 5) {
            array_push($this->errorArray, Constants::$usernameCharacters);
            return;
        }

        // Prepared statement para prevenir SQL Injection
        $stmt = mysqli_prepare($this->con, "SELECT username FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $un);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) != 0) {
            array_push($this->errorArray, Constants::$usernameTaken);
        }

        mysqli_stmt_close($stmt);
    }

    private function validateFirstName($fn) {
        // Permite acentos brasileiros: á, é, í, ó, ú, ã, õ, ç, Á, É, Í, Ó, Ú, Ã, Õ, Ç
        if (!preg_match('/^[a-zA-ZáéíóúãõçÁÉÍÓÚÃÕÇ\s]{2,25}$/u', $fn)) {
            array_push($this->errorArray, Constants::$firstNameCharacters);
            return;
        }
    }

    private function validateLastName($ln) {
        // Permite acentos brasileiros: á, é, í, ó, ú, ã, õ, ç, Á, É, Í, Ó, Ú, Ã, Õ, Ç
        if (!preg_match('/^[a-zA-ZáéíóúãõçÁÉÍÓÚÃÕÇ\s]{2,25}$/u', $ln)) {
            array_push($this->errorArray, Constants::$lastNameCharacters);
            return;
        }
    }

    private function validateEmails($em, $em2) {
        if ($em != $em2) {
            array_push($this->errorArray, Constants::$emailsDoNotMatch);
        }

        // Validação de email aceitando domínios brasileiros comuns
        if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }

        // Validação adicional para aceitar domínios brasileiros populares
        // gmail.com, hotmail.com, outlook.com, yahoo.com.br, uol.com.br, bol.com.br, terra.com.br
        $allowedDomains = ['gmail.com', 'hotmail.com', 'outlook.com', 'yahoo.com.br', 'yahoo.com',
                          'uol.com.br', 'bol.com.br', 'terra.com.br', 'live.com', 'icloud.com'];

        $emailParts = explode('@', $em);
        if (count($emailParts) == 2) {
            $domain = strtolower($emailParts[1]);
            // Aceita qualquer domínio válido, mas recomenda os populares brasileiros
        }

        // Prepared statement para prevenir SQL Injection
        $stmt = mysqli_prepare($this->con, "SELECT email FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $em);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) != 0) {
            array_push($this->errorArray, Constants::$emailTaken);
        }

        mysqli_stmt_close($stmt);
    }

    private function validatePasswords($pw, $pw2) {
        if ($pw != $pw2) {
            array_push($this->errorArray, Constants::$passwordsDoNotMatch);
            return;
        }

        if (preg_match('/[^A-Za-z0-9]/', $pw)) {
            array_push($this->errorArray, Constants::$passwordNotAlphanumeric);
            return;
        }

        if (strlen($pw) > 30 || strlen($pw) < 5) {
            array_push($this->errorArray, Constants::$passwordCharacters);
            return;
        }
    }
}


?>