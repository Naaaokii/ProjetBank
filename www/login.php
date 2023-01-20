<?php

require_once __DIR__ . '/../src/init.php';
// $db
// $_SESSION

if(isset($_SESSION['email'])){
    header("location:myaccount.php");
}
if(isset($_POST['connexion'])){
    if (isset($_POST['email']) && isset($_POST['password'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        if (!empty($email) AND !empty($password)){
            $hashpassword = hash('sha256', $password);
            $req = $dbh->prepare('SELECT * FROM users WHERE email = :email and motdepasse = :motdepasse');
            $req-> execute(array('email' => $email, 'motdepasse' => $hashpassword));
            $resultat = $req->fetch(); 
            if (!$resultat){
                $message = "wrong password or mail";
            }//else{
            //     $message = "right password and mail";
            //     echo "<script type='text/javascript'>alert('$message');</script>";
            //     $email  = $_POST['email'];
            //     $user_info = $dbh->prepare('SELECT nom, prenom,email,telephone,date_de_naissance,role FROM users WHERE email = :email');
            //     $user_info->bindValue(':email', $email);
            //     $user_info->execute();
            //     $resultat = $req->fetch(PDO::FETCH_ASSOC);
            //     foreach($resultat as $key => $val){
            //         if ($key % 2 == 0) {
            //             $_SESSION[$key] = $val;
            //         }
            //     }
            // }
            else {
                $_SESSION["email"] = $email;
                $_SESSION["password"] = $hpass;
                header("location:index.php");
            }
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
                <img src="assets/imgs/logo_bankade.png">
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
                                <input class='button' type="submit" value="Connexion" name="connexion" class="inpbutton"> 
                                <a href="register.php" class="reglink">Inscription</a>
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