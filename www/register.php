<?php

require_once __DIR__ . '/../src/init.php';
// $db
// $_SESSION

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ACCUEIL</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="/assets/style/style.css">
    </head>
    <body>
        <header>
            <?php
            require_once __DIR__ . '/../src/templates/partials/header.php';
            ?>
        </header>
        <h1 class='title'>INSCRIPTION</h1>
        <section class="register">
            <section class='border_register'>
                <form method="post" class="user-box">
                    <div class="zone_register">
                        <input class="integrate_text" type="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="zone_register">
                        <input class="integrate_text" type="text" name="username" placeholder="Pseudo" required>
                    </div>
                    <div class="zone_register">
                        <input class="integrate_text password" id="pwd" type="password" name="password" placeholder="Mot de passe" >
                    </div>
                    <div class="zone_register">
                        <input class="integrate_text" type="password" name="confirm_password" placeholder="Confirmer le mot de passe"  required>
                    </div>
                    <div class="space_register">
                        <input class="button_register" type="submit" name="reg_user" placeholder="Inscription"><a href="login.php" class="connect">Connexion</a>
                    </div>
                </form>
            </section>
        </section>
        <footer class='footer'>
            <?php 
                require_once __DIR__ . '/../src/templates/partials/footer.php'; 
            ?>
        </footer>  
    </body>
</html>