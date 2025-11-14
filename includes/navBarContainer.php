<div id="navBarContainer">
    <nav class="navBar">
        <span role="link" tabindex="0" onclick="openPage('index.php')" class="logo">
            <img src="assets/images/icons/logo.png" alt="logo">
        </span>

        <div class="group">
            <div class="navItem">
                <!-- USE THIS as model to create links that dynamically load -->
                <span role='link' tabindex='0' onclick="openPage('search.php')" class="navItemLink">Buscar
                    <img src="assets/images/icons/search.png" alt="Buscar" class="icon">
                </span>
            </div>
        </div>

            <div class="group">
                <div class="navItem">
                    <span role="link" tabindex="0" onclick="openPage('browse.php')" class="navItemLink">Explorar</span>
                </div>
                <div class="navItem">
                    <span role="link" tabindex="0" onclick="openPage('yourMusic.php')" class="navItemLink">Sua Música</span>
                </div>
                <div class="navItem">
                    <span role="link" tabindex="0" onclick="openPage('settings.php')"  class="navItemLink">
                        <?php
                        if(isset($userLoggedIn) && $userLoggedIn != null) {
                            echo $userLoggedIn->getFirstAndLastName();
                        } else {
                            echo "Perfil";
                        }
                        ?>
                    </span>
                </div>

            </div>
    </nav>
</div>