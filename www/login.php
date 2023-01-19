<?php

require_once __DIR__ . '/../src/init.php';
// $db
// $_SESSION

if(isset($_SESSION['email'])){
    header("location:myaccount.php");
}
    if(ISSET($_POST['connexion'])){
        if (isset($_POST['email']) && isset($_POST['password'])){
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (!empty($email) AND !empty($password)){
                $hashpassword = hash('sha256', $password);
                $req = $dbh->prepare('SELECT * FROM users WHERE email = :email and motdepasse = :motdepasse');
                $req-> execute(array('email' => $email, 'motdepasse' => $hashpassword));
                $resultat = $req->fetch(); 
            }
            if (!$resultat){
                echo 'Email ou mot de passe invalide';
            }
            else {
                $user_id = ('SELECT id FROM user WHERE email= $email');
                $_SESSION["email"] = $email;
                $_SESSION["password"] = $hpass;
                header("location:index.php");
            }
        }
    }
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
                        <h2>Se connecter à son compte utilisateur</h2>
                    </div>
                    <?php
                        if(isset($emptyfield)){
                            echo '<div class="alerts alerts-success">'.$emptyfield.'</div>';
                        }
                        if(isset($loginerror)){
                            echo '<div class="alerts alerts-success">'.$loginerror.'</div>';
                        }
                    ?>
                    <form method="post">
                            <div>
                                <input class="zone" type="email"  name="email"  id="email"  placeholder="Email" required>
                            </div>
                            <div>
                                <input class="zone" type="password"  name="password"  id="pass"  placeholder="Mot de passe" autocomplete="current-password" minlength="8" maxlength="16" required>
                            </div>
                            <a href="#" class="mdp">Mot de passe oublié ?</a>
                            <div class="align">
                                <input class='button' type="submit" value="connexion" name="connexion" class="inpbutton"> <a href="register.php" class="reglink">Inscription</a>
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