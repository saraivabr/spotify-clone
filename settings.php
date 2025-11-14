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
                    echo "User Settings";
                }
                ?>
            </h1>
        </div>
    </div>

    <div class="buttonItems">
        <button class="button" onclick="openPage('updateDetails.php')">USER DETAILS</button>
        <button class="button" onclick="logout()">LOGOUT</button>
    </div>
</div>