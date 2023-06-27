<?php
    if(isset($_GET['page']) && isset($_GET['url'])) {
        if($_GET['page'] != ("login" || "register" || "new" || "reset")) {
            header("Location: ".$indexUrl);
        }
        $backUrl = $_GET ['url'];
    }
    else {
        header("Location: ".$indexUrl);
    }

    require_once("includes/header.php");

    require_once("includes/classes/Account.php");
    require_once("includes/classes/Constans.php");
    require_once("includes/classes/SendEmail.php");
    $account = new Account($con);
    $constans = new Constans();

    require_once("includes/handlers/register-handler.php");
	require_once("includes/handlers/login-handler.php");
    require_once("includes/handlers/newPassword-handler.php");

    function getInputValue($inputText) {
        if(isset($_POST[$inputText])) {
            echo strip_tags($_POST[$inputText]);
        }
    }

    if(str_contains($backUrl, "userId_") && str_contains($backUrl, "_tempPw_")) {
        $array = explode("_", $backUrl);
        $userId = $array[1];
        $password = $array[3];
        $encryptedPw = md5($password);

        $Q = mysqli_query($con, "SELECT * FROM users WHERE id=$userId AND password='$encryptedPw'");
        if(mysqli_num_rows($Q)) {
            $R = mysqli_fetch_array($Q);
            $username = $R['username'];
        }
    }

?>

<style><?php require_once("assets/css/login.css"); ?></style>

<div class="loginContainerAll">
    
    <div class="div loginContainer">

        <div class="loginDiv">

            <?php echo $functions->getLoading("loadingLogin", "FILMOVE.TV"); ?>

            <!--REGISTER START -->
            <div id="register">
                <form id="registerForm" action="register/back=<?php echo $_GET['url']; ?>" method="POST">

                    <div class="loginHeader">Stwórz konto</div>

                    <div class="input">
                        <i class="fas fa-user icon"></i>
                        <input id="username" class="button1 inputLogin" name="username" type="text" placeholder="" value="<?php echo getInputValue('username'); ?>" required>
                        <div class="placeholder">Login</div>
                        <?php echo $account->getError(Constans::$usernameStrlen, "username"); ?>
                        <?php echo $account->getError(Constans::$usernameInvalidCharacters, "username"); ?>
                        <?php echo $account->getError(Constans::$usernameTaken, "username"); ?>
                    </div>

                    <div class="input">
                        <i class="fas fa-at icon"></i>
                        <input id="email" class="button1 inputLogin" name="email" type="email" placeholder="" value="<?php echo getInputValue('email'); ?>" required>
                        <div class="placeholder">E-mail</div>
                        <?php echo $account->getError(Constans::$emailInvalid, "email"); ?>
                        <?php echo $account->getError(Constans::$emailTaken, "email"); ?>
                        <?php echo $account->getError(Constans::$emailsDonNoMatch, "email"); ?>
                    </div>

                    <div class="input">
                        <i class="fas fa-at icon"></i>
                        <input class="button1 inputLogin" name="email2" type="email" placeholder="" value="<?php echo getInputValue('email2'); ?>" required>
                        <div class="placeholder">Potwierdź E-mail</div>
                    </div>

                    <div class="input">  
                        <i class="fas fa-lock icon"></i>
                        <input id="password" class="button1 inputLogin" name="password" type="password" placeholder="" value="" required>
                        <div class="placeholder">Hasło</div>
                        <?php echo $account->getError(Constans::$passwordStrlen, "password"); ?>
                        <?php echo $account->getError(Constans::$passwordInvalidCharacters, "password"); ?>
                        <?php echo $account->getError(Constans::$passwordsDoNoMatch, "password"); ?>
                    </div>

                    <div class="input">
                        <i class="fas fa-lock icon"></i>
                        <input class="button1 inputLogin" name="password2" type="password" placeholder="" value="" required>
                        <div class="placeholder">Potwierdź hasło</div>
                    </div>

                    <label class="container">
                        <div class="checkboxBox">
                            <input type="checkbox" required>
                            <span class="checkmark"></span>
                        </div>

                        <div class="checkboxText">
                            Akceptuję <a href="regulamin" class="regulaminAccept">regulamin</a> świadczenia usługi i zobowiązuję się do jego przestrzegania.
                        </div>
                    </label>

                    <button class="button2 buttonLogin" name="registerButton">Stwórz</button>

                    <div id="loginShow" class="loginShow linkHoverEffect">Masz już konto? Zaloguj się tutaj!</div>

                </form>
            </div>
            <!--REGISTER END -->

            <!--LOGIN START -->
            <div id="login">
                <form id="loginForm" action="login/back=<?php echo $_GET['url']; ?>" method="POST">         

                    <div class="loginHeader">Zaloguj się</div>

                    <div class="input">
                        <i class="fas fa-user icon"></i>
                        <input id="usernameEmail" class="button1 inputLogin" name="usernameEmail" type="text" placeholder="" value="<?php echo getInputValue('usernameEmail'); ?>" required>
                        <div class="placeholder">Login lub E-mail</div>
                        <?php echo $account->getError(Constans::$loginFailed, "usernameEmail"); ?>
                    </div>

                    <div class="input">
                        <i class="fas fa-lock icon"></i>
                        <input id="passwordL" class="button1 inputLogin" name="loginPassword" type="password" placeholder="" value="" required>
                        <div class="placeholder">Hasło</div>
                    </div>

                    <button class="button2 buttonLogin" name="loginButton">Zaloguj się</button>

                    <div id="resetShow" class="loginShow linkHoverEffect resetShow">Zapomniałeś hasła?</div>
                    <div id="registerShow" class="loginShow linkHoverEffect">Nie masz konta? Stwórz je tutaj!</div>

                </form>
            </div>
            <!--LOGIN END -->

            <!--RESET PASSWORD START -->
            <div id="reset">
                <form id="resetForm" action="reset/back=<?php echo $_GET['url']; ?>" method="POST">      

                    <div class="loginHeader">Nowe hasło</div>

                    <div class='input'>
                        <i class='fas fa-at icon'></i>
                        <input id='emailR' class='button1 inputLogin' name='emailR' type='email' placeholder='' value='' required>
                        <div class='placeholder'>E-mail</div>
                        <?php echo $account->getError(Constans::$resetPassword, "emailR"); ?>
                    </div>

                    <button class='button2 buttonLogin' name='resetPasswordButton'>Resetuj hasło</button>

                    <div id="loginShow2" class="loginShow linkHoverEffect">Zaloguj się tutaj!</div>

                </form>
            </div>
            <!--RESET PASSWORD END -->

            <!--RESET2 PASSWORD START -->
            <div id="reset2">
                <form id="reset2Form" action="reset2/back=<?php echo $_GET['url']; ?>" method="POST">

                    <div class="loginHeader">Nowe hasło</div>

                    <input name="usernameR" type="hidden" value="<?php echo $username; ?>">

                    <input name="passwordR" type="hidden" value="<?php echo $password; ?>">

                    <div class="input">  
                        <i class="fas fa-lock icon"></i>
                        <input id="passwordRN" class="button1 inputLogin" name="passwordRN" type="password" placeholder="" value="" required>
                        <div class="placeholder">Nowe hasło</div>
                        <?php echo $account->getError(Constans::$passwordStrlen, "passwordRN"); ?>
                        <?php echo $account->getError(Constans::$passwordInvalidCharacters, "passwordRN"); ?>
                        <?php echo $account->getError(Constans::$passwordsDoNoMatch, "passwordRN"); ?>
                    </div>

                    <div class="input">
                        <i class="fas fa-lock icon"></i>
                        <input class="button1 inputLogin" name="passwordRN2" type="password" placeholder="" value="" required>
                        <div class="placeholder">Potwierdź nowe hasło</div>
                    </div>

                    <button class='button2 buttonLogin' name='resetPassword2Button'>Zmień hasło</button>

                </form>
            </div>
            <!--RESET2 PASSWORD END -->

            <!--NEW PASSWORD START -->
            <div id="new">
                <form id="newForm" action="new/back=<?php echo $_GET['url']; ?>" method="POST">

                    <div class="loginHeader">Nowe hasło</div>

                    <div class="input">
                        <i class="fas fa-lock icon"></i>
                        <input id="passwordC" class="button1 inputLogin" name="passwordC" type="password" placeholder="" value="" required>
                        <div class="placeholder">Aktualne hasło</div>
                        <?php echo $account->getError(Constans::$newPassword, "passwordC"); ?>
                    </div>

                    <div class="input">  
                        <i class="fas fa-lock icon"></i>
                        <input id="passwordN" class="button1 inputLogin" name="passwordN" type="password" placeholder="" value="" required>
                        <div class="placeholder">Nowe hasło</div>
                        <?php echo $account->getError(Constans::$passwordStrlen, "passwordN"); ?>
                        <?php echo $account->getError(Constans::$passwordInvalidCharacters, "passwordN"); ?>
                        <?php echo $account->getError(Constans::$passwordsDoNoMatch, "passwordN"); ?>
                    </div>

                    <div class="input">
                        <i class="fas fa-lock icon"></i>
                        <input class="button1 inputLogin" name="passwordN2" type="password" placeholder="" value="" required>
                        <div class="placeholder">Potwierdź nowe hasło</div>
                    </div>

                    <button class='button2 buttonLogin' name='newPasswordButton'>Zmień hasło</button>

                </form>
            </div>
            <!--NEW PASSWORD END -->  

        </div>

    </div>


</div>

<script>
    $("#openRandomEntityContainer").attr('style','display: none!important');
    $("#navContainerCategory").attr('style','display: none!important');
    $("#navContainerMenu").attr('style','display: none!important');
    $("#backNavContainer").attr('style','display: block!important');
    $("#<?php echo $_GET['page']?>").attr('style','display: block!important');

    <?php require_once("assets/js/login.js"); ?>
</script>
