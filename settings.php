<?php 
include("includes/includedFiles.php");
?>

<div class="entityInfo">

    <div class="centerSection">
        <div class="userInfo">
            <h1>
                <?php
                if(isset($userLoggedIn) && $userLoggedIn != null) {
                    echo $userLoggedIn->getFirstAndLastName();
                } else {
                    echo "Configurações do Usuário";
                }
                ?>
            </h1>
        </div>
    </div>

    <div class="buttonItems">
        <button class="button" onclick="openPage('updateDetails.php')">MEUS DADOS</button>
        <button class="button" onclick="logout()">SAIR</button>
    </div>
</div>