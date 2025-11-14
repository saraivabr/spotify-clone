<?php 
include("../../config.php");

if (!isset($_POST['username'])) {
    echo "ERROR: Could not set username";
    exit();
}

if (!isset($_POST['oldPassword']) || !isset($_POST['newPassword1']) || !isset($_POST['newPassword2'])) {
    echo "Not all passwords have been set";
    exit();
}

if ($_POST['oldPassword'] == "" || $_POST['newPassword1'] == "" || $_POST['newPassword2'] == "") {
    echo "Please fill in all fields";
    exit();
}

$username = $_POST['username'];
$oldPassword = $_POST['oldPassword'];
$newPassword1 = $_POST['newPassword1'];
$newPassword2 = $_POST['newPassword2'];

// Prepared statement para verificar senha atual
$stmt = mysqli_prepare($con, "SELECT password FROM users WHERE username = ?");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    // Verificar senha com password_verify
    if (!password_verify($oldPassword, $row['password'])) {
        mysqli_stmt_close($stmt);
        echo "Password is incorrect";
        exit();
    }
} else {
    mysqli_stmt_close($stmt);
    echo "Password is incorrect";
    exit();
}
mysqli_stmt_close($stmt);

if ($newPassword1 != $newPassword2) {
    echo "Your new passwords do not match";
    exit();
}

if (preg_match('/[^A-Za-z0-9]/', $newPassword1)) {
    echo "Your password must only contain letters and/or numbers";
    exit();
}

if (strlen($newPassword1) > 30 || strlen($newPassword1) < 5) {
    echo "Your password must be between 5 and 30 characters";
    exit();
}

// Usar password_hash em vez de MD5
$hashedPassword = password_hash($newPassword1, PASSWORD_DEFAULT);

// Prepared statement para atualizar senha
$stmt = mysqli_prepare($con, "UPDATE users SET password = ? WHERE username = ?");
mysqli_stmt_bind_param($stmt, "ss", $hashedPassword, $username);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

echo "Update password successful";

?>