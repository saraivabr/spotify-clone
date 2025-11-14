<?php 
include("includes/includedFiles.php");
?>

<div class="userDetails">
    <div class="container borderBottom">
        <h2>EMAIL</h2>
        <input type="text" class="email" name="email" placeholder="Seu endereço de email.." value="<?php echo (isset($userLoggedIn) && $userLoggedIn != null) ? $userLoggedIn->getEmail() : ''; ?>">
        <span class="message"></span>
        <button class="button" onclick="updateEmail('email')">SALVAR</button>
    </div>
    <div class="container">
        <h2>SENHA</h2>
        <input type="password" class="oldPassword" name="oldPassword" placeholder="Senha atual">
        <input type="password" class="newPassword1" name="newPassword1" placeholder="Nova senha">
        <input type="password" class="newPassword2" name="newPassword2" placeholder="Confirme a nova senha">
        <span class="message"></span>
        <button class="button" onclick="updatePassword('oldPassword', 'newPassword1', 'newPassword2')">SALVAR</button>
    </div>
</div>