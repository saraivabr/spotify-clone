<?php 
include("../../config.php");

if (!isset($_POST['username'])) {
    echo "ERROR: Could not set username";
    exit();
}

if (isset($_POST['email']) && ($_POST['email']) != "") {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email is invalid";
        exit();
    }

    // Prepared statement para verificar email duplicado
    $stmt = mysqli_prepare($con, "SELECT email FROM users WHERE email = ? AND username != ?");
    mysqli_stmt_bind_param($stmt, "ss", $email, $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_close($stmt);
        echo "Email is already in use";
        exit();
    }
    mysqli_stmt_close($stmt);

    // Prepared statement para atualizar email
    $stmt = mysqli_prepare($con, "UPDATE users SET email = ? WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "ss", $email, $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    echo "Update successful";

}
else {
    echo "You must provide a username";
}


?>