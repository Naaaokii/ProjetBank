<?php

require_once __DIR__ . '/../src/init.php';
// $db
// $_SESSION
if(isset($_SESSION['email'])){
    header("location:myaccount.php");
}
$erremail = $errpassword = $errconfpassword = $mdperrors = $usererrors = $success = "";
$mdpreq = $confmdpreq = $emailok = 0;
            
            if(ISSET($_POST['reg_user'])){
                if(ISSET($_POST['name'], $_POST['firstname'], $_POST['email'], $_POST['number'], $_POST['date'], $_POST['password'],$_POST['confirm_password'])
            && !empty($_POST['name']) && !empty($_POST['firstname']) && !empty($_POST['email']) && !empty($_POST['number']) && !empty($_POST['date']) && !empty($_POST['password']) && !empty($_POST['confirm_password']))
                {
                $name = trim($_POST['name']);
                $firstName = trim($_POST['firstname']);
                $email = trim($_POST['email']);
                $number = $_POST['number'];
                $date = $_POST['date'];
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];
                $userreq = array("cost" => 4);
            //--------------Password check---------------
                    if (strlen($password) < 8 || strlen($password) > 16) {
                        $mdperrors = "Password should be min 8 characters and max 16 characters";
                    }
                    if (!preg_match("/\d/", $password)) {
                        $mdperrors = "Password should contain at least one digit";
                    }
                    if (!preg_match("/[A-Z]/", $password)) {
                        $mdperrors = "Password should contain at least one Capital Letter";
                    }
                    if (!preg_match("/[a-z]/", $password)) {
                        $mdperrors = "Password should contain at least one small Letter";
                    }
                    if (!preg_match("/\W/", $password)) {
                        $mdperrors = "Password should contain at least one special character";
                    }
                    if (preg_match("/\s/", $password)) {
                        $mdperrors = "Password should not contain any white space";
                    }
                    if ($mdperrors) {
                            $mdpreq = 1;
                    } else {
                        $mdpreq = 2;
                    }
                    if(empty($_POST["confirm_password"])){
                        $errconfpassword = "Confirm password is required";
                        $confmdpreq = 1;
                    } elseif($_POST["password"] == $_POST["confirm_password"]){
                        $confmdpreq = 2;
                    } else{
                        $errconfpassword = "password is different";
                        $confmdpreq = 3;
                    }
            //----------------email check------------------
                    if (empty($_POST["email"])) {
                        $erremail = "Email is required";
                        $emailok = 1;
                    } else {
                        $email = test_input($_POST["email"]);
                        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                            $erremail = "Invalid email format";
                        }else{
                            $emailok = 2;
                        }
                    }
                    if($mdpreq == 2 && $confmdpreq == 2 && $emailok == 2){
                        $sth = $dbh->prepare("INSERT INTO users (nom, prenom, email, telephone, date_de_naissance, motdepasse, `role`) VALUES (?,?,?,?,?,?,?)");
                        $sth->execute([$name, $firstName, $email, $number, $date, hash('sha256', $password), 'unverified']);
                        $success = 'User has been created successfully';
                        header("Refresh: 2; url=http://localhost:8888/login.php");
                    }
                }   
            }
            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
?>

<?php
    $page_title = 'INSCRIPTION';
    require_once __DIR__ . '/../src/templates/partials/html_head.php';
?>
    <body>
        <header>
            <?php
            require_once __DIR__ . '/../src/templates/partials/header.php';
            ?>
        </header>
        <h1 class='title'>INSCRIPTION</h1>
        <?php 
            if(isset($success)){
                echo '<div class="alert alerts-success">'.$success.'</div>';
            }
        ?>
        <section class="register">
            <section class='border_register'>
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" class="user-box">
                    <div class="zone_register">
                        <input class="integrate_text" type="text" name="name" placeholder="Nom" required>
                    </div>
                    <div class="zone_register">
                        <input class="integrate_text" type="text" name="firstname" placeholder="Prenom" required>
                    </div>
                    <div class="zone_register">
                        <input class="integrate_text" type="email" name="email" placeholder="Email" required>
                        <span class="error"><?php echo $erremail ?></span>
                    </div>
                    <div class="zone_register">
                        <input class="integrate_text" type="tel" name="number" placeholder="Numero de telephone" required>
                    </div>
                    <div class="zone_register">
                        <input class="integrate_text" type="date" name="date" placeholder="Date de naissance" required>
                    </div>
                    <div class="zone_register">
                        <input class="integrate_text password" id="pwd" type="password" name="password" placeholder="Mot de passe" >
                        <span class="error"><?php echo $mdperrors ?></span>
                    </div>
                    <div class="zone_register">
                        <input class="integrate_text" type="password" name="confirm_password" placeholder="Confirmer le mot de passe"  required>
                        <span class="error"><?php echo $errconfpassword ?></span>
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