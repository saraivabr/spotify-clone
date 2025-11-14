<?php 
include("../../config.php");

if (!isset($_POST['username'])) {
    echo "ERRO: Não foi possível definir o usuário";
    exit();
}

if (!isset($_POST['oldPassword']) || !isset($_POST['newPassword1']) || !isset($_POST['newPassword2'])) {
    echo "Nem todas as senhas foram definidas";
    exit();
}

if ($_POST['oldPassword'] == "" || $_POST['newPassword1'] == "" || $_POST['newPassword2'] == "") {
    echo "Por favor, preencha todos os campos";
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
        echo "Senha incorreta";
        exit();
    }
} else {
    mysqli_stmt_close($stmt);
    echo "Senha incorreta";
    exit();
}
mysqli_stmt_close($stmt);

if ($newPassword1 != $newPassword2) {
    echo "As novas senhas não coincidem";
    exit();
}

if (preg_match('/[^A-Za-z0-9]/', $newPassword1)) {
    echo "Sua senha só pode conter letras e/ou números";
    exit();
}

if (strlen($newPassword1) > 30 || strlen($newPassword1) < 5) {
    echo "Sua senha deve ter entre 5 e 30 caracteres";
    exit();
}

// Usar password_hash em vez de MD5
$hashedPassword = password_hash($newPassword1, PASSWORD_DEFAULT);

// Prepared statement para atualizar senha
$stmt = mysqli_prepare($con, "UPDATE users SET password = ? WHERE username = ?");
mysqli_stmt_bind_param($stmt, "ss", $hashedPassword, $username);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

echo "Senha atualizada com sucesso";

?>