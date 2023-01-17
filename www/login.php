<?php

require_once __DIR__ . '/../src/init.php';
// $db
// $_SESSION

?>

<?php
    $page_title = 'LOGIN';
    require_once __DIR__ . '/../src/templates/partials/html_head.php';
?>
    <body>
        <header>
            <?php
            require_once __DIR__ . '/../src/templates/partials/header.php';
            ?>
        </header>
        <div class="connexion">
            <section class="block_logo">
                <img src="assets/imgs/logo_helices.png">
            </section>
            <section class="block_form">
                <div class="total">
                    <div>
                        <h2>Se connecter à son compte</h2>
                    </div>
                    <form method="post">
                            <div>
                                <input class="zone" type="email"  name="email"  id="email"  placeholder="Email" required>
                            </div>
                            <div>
                                <input class="zone" type="password"  name="password"  id="pass"  placeholder="Mot de passe" autocomplete="current-password" minlength="8" maxlength="16" required>
                            </div>
                            <a href="#" class="mdp">Mot de passe oublié ?</a>
                            <div class="align">
                                <a href="dashboard.html" class='button'>Se connecter</a> <a href="register.php" class="reglink">Inscription</a>
                            </div>
                    </form>
                </div>
            </section>
        </div>
        <footer class='footer'>
            <?php 
                require_once __DIR__ . '/../src/templates/partials/footer.php'; 
            ?>
        </footer>  
    </body>
</html>