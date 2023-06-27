<?php
    require_once("includes/header.php");
    require_once("includes/classes/Account.php");
    require_once("includes/classes/Constans.php");
    $account = new Account($con);
    $constans = new Constans();
    require_once("includes/handlers/newPassword-handler.php");

    if($userLoggedIn == 'anonim') {
        $content = "<div class='input'>
                        <i class='fas fa-at icon'></i>
                        <input id='email' class='button1 inputLogin' name='email' type='text' placeholder='' value='' required>
                        <div class='placeholder'>E-mail</div>
                        ".$account->getError(Constans::$newPassword, 'email')."
                    </div>

                    <button class='button2 buttonLogin' name='newPasswordAnonimButton'>Resetuj hasło</button>";
    }else {
        $content = "<div class='input'>
                        <i class='fas fa-lock icon'></i>
                        <input id='currentPassword' class='button1 inputLogin' name='currentPassword' type='text' placeholder='' value='' required>
                        <div class='placeholder'>Obecne hasło</div>
                        ".$account->getError(Constans::$newPassword, 'currentPassword')."
                    </div>

                    <div class='input'>
                        <i class='fas fa-lock icon'></i>
                        <input id='password' class='button1 inputLogin' name='password' type='text' placeholder='' value='' required>
                        <div class='placeholder'>Nowe hasło</div>
                        ".$account->getError(Constans::$newPassword, 'password')."
                    </div>

                    <div class='input'>
                        <i class='fas fa-lock icon'></i>
                        <input id='password2' class='button1 inputLogin' name='password2' type='text' placeholder='' value='' required>
                        <div class='placeholder'>Powtórz nowe hasło</div>
                        ".$account->getError(Constans::$newPassword, 'password2')."
                    </div>

                    <button class='button2 buttonLogin' name='newPasswordLoggedInButton'>Zmień hasło</button>";
    }
?>

<style><?php require_once("assets/css/login.css"); ?></style>

<div class="loginContainerAll">
    
    <div class="div loginContainer">

        <div class="loginDiv">

            <?php echo $functions->getLoading("loadingLogin", "FILMOVE.TV"); ?>

            <div id="newPassword">
                <form id="loginForm" action="nowe-haslo/back=<?php echo $_GET['url']; ?>" method="POST">         

                    <div class="loginHeader">Nowe hasło</div>

                    <?php echo $content; ?>

                </form>
            </div>

        </div>
    </div>
</div>

<script>
    $("#openRandomEntityContainer").attr('style','display: none!important');
    $("#navContainerCategory").attr('style','display: none!important');
    $("#navContainerMenu").attr('style','display: none!important');
    $("#backNavContainer").attr('style','display: block!important');

    <?php require_once("assets/js/login.js"); ?>
</script>