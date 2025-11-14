<?php 
include("includes/config.php");
include("includes/classes/Account.php");
include("includes/classes/Constants.php");

$account = new Account($con);

include("includes/handlers/register-handler.php");
include("includes/handlers/login-handler.php");


function getInputValue($name) {
    if (isset($_POST[$name])) {
        echo $_POST[$name];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cadastre-se gratuitamente no Spotify Brasil e descubra milhões de músicas. Crie suas playlists e curta música de qualidade!">
    <meta name="keywords" content="spotify brasil, música online, streaming, cadastro gratuito">
    <title>Cadastre-se no Spotify Brasil 🎵</title>

    <link rel="stylesheet" href="assets/css/register.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="assets/js/register.js"></script>
</head>
<body>
    
<?php 
    if (isset($_POST['registerButton'])) {
        echo '<script>
                $(document).ready(function() {
                $("#loginForm").hide();
                $("#registerForm").show();
                });
                </script>';
                }
    else {
        echo '<script>
                $(document).ready(function() {
                $("#loginForm").show();
                $("#registerForm").hide();
                });
            </script>';
        }
?>

<div id="background">
    <div id="loginContainer">
        <div id="inputContainer">
            <form id="loginForm" action="register.php" method="POST">
                <h2>Entre na sua conta</h2>
                <p>
                <?php echo $account->getError(Constants::$loginFailed); ?>
                    <label for="loginUsername">Usuário:</label>
                    <input id="loginUsername" name="loginUsername" type="text" placeholder="BartSimpson" value="<?php getInputValue('loginUsername'); ?>" required>
                </p>
                <p>
                    <label for="loginPassword">Senha:</label>
                    <input id="loginPassword" name="loginPassword" type="password" placeholder="Sua senha" required>
                </p>
                <button type="submit" name="loginButton">ENTRAR</button>

                <div class="hasAccountText">
                    <span id="hideLogin">Não tem uma conta? Cadastre-se aqui</span>
                </div>
            </form>
            
            <form id="registerForm" action="register.php" method="POST">
                <h2>Crie sua conta grátis</h2>
                <p>
                    <?php echo $account->getError(Constants::$usernameCharacters); ?>
                    <?php echo $account->getError(Constants::$usernameTaken); ?>
                    <label for="username">Usuário:</label>
                    <input id="username" name="username" type="text" placeholder="BartSimpson" value="<?php getInputValue('username');?>" required>
                </p>
                <p>
                    <?php echo $account->getError(Constants::$firstNameCharacters); ?>
                    <label for="firstName">Nome:</label>
                    <input id="firstName" name="firstName" type="text" placeholder="Bart" value="<?php getInputValue('firstName'); ?>" required>
                </p>
                <p>
                    <?php echo $account->getError(Constants::$lastNameCharacters); ?>
                    <label for="lastName">Sobrenome:</label>
                    <input id="lastName" name="lastName" type="text" placeholder="Simpson" value="<?php getInputValue('lastName'); ?>" required>
                </p>
                <p>
                    <?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
                    <?php echo $account->getError(Constants::$emailInvalid); ?>
                    <?php echo $account->getError(Constants::$emailTaken); ?>
                    <label for="email">Email:</label>
                    <input id="email" name="email" type="email" placeholder="bart@gmail.com" value="<?php getInputValue('email'); ?>" required>
                </p>
                <p>
                    <label for="email2">Confirme seu email:</label>
                    <input id="email2" name="email2" type="email" placeholder="bart@gmail.com" value="<?php getInputValue('email2'); ?>" required>
                </p>
                <p>
                    <?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
                    <?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
                    <?php echo $account->getError(Constants::$passwordCharacters); ?>
                    <label for="password">Senha:</label>
                    <input id="password" name="password" type="password" placeholder="Sua senha" required>
                </p>
                <p>
                    <label for="password2">Confirme sua senha:</label>
                    <input id="password2" name="password2" type="password" placeholder="Sua senha" required>
                </p>
                <button type="submit" name="registerButton">CADASTRAR</button>

                <div class="hasAccountText">
                    <span id="hideRegister">Já tem uma conta? Entre aqui</span>
                </div>
            </form>
        </div>
        <div id="loginText">
            <h1>🇧🇷 Bem-vindo ao Spotify Brasil!</h1>
            <h2>Milhões de músicas esperando por você 🎶</h2>
            <ul>
                <li>🎵 Descubra músicas incríveis do Brasil e do mundo</li>
                <li>📱 Crie suas playlists personalizadas</li>
                <li>⭐ Siga seus artistas favoritos</li>
                <li>🎧 Totalmente grátis para começar</li>
            </ul>
        </div>
    </div>
</div>
    
</body>
</html>