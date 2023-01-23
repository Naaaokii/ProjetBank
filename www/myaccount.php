<?php

require_once __DIR__ . '/../src/init.php';
// $db
// $_SESSION
if(empty($_SESSION['email'])){
    header("location:login.php");
}else{
    $email = $_SESSION['email'];
    $sqladmin = $dbh->prepare('SELECT role FROM users WHERE email = :email');
    $sqladmin->execute(array("email" => $email));
    $role = $sqladmin->fetchAll();
    foreach($role as $key => $qui){
        if($qui['role'] == "banned" || $qui['role'] == "unverified" ){
            header('location:register.php');
        }
    }
}

if(ISSET($_POST['deconnexion'])){
    session_destroy();
    header("location:login.php");
}

$page_title = 'MON ESPACE';
require_once __DIR__ . '/../src/templates/partials/html_head.php';
?>

    <body>
        <header>
            <?php
            require_once __DIR__ . '/../src/templates/partials/header.php';
            ?>
        </header>
        <h1 class='title'>Mon compte</h1>
        <?php
            $user_mail = $_SESSION['email'];
            $req = $dbh->prepare('SELECT ID AS Identifiant, nom AS Nom, prenom AS Prénom, date_de_naissance AS né_le, email,
            telephone FROM users WHERE email = :email');
            $req->execute(array('email' => $user_mail));
            $user = $req->fetch(PDO::FETCH_ASSOC);
            echo "<div class='rib'>";
            foreach ($user as $key => $value) {
                echo "<h3 class='ribinfo'>" . $key . " : " . $value . "</h3><br>";
                if($key=='Identifiant'){
                    $_SESSION["ID"] = $value;
                }
            }
            echo "</div>";
        $reqct = $dbh->prepare('SELECT comptes.numero, comptes.id_Cmpt, comptes.solde , monnaies.nom AS devise FROM
        comptes INNER JOIN monnaies ON  comptes.id_monnaie = monnaies.id_Monnaie WHERE comptes.id_user = :id_user ;');
        $reqct->execute(array('id_user' => $_SESSION["ID"]));
        $comptes = $reqct->fetchAll(PDO::FETCH_ASSOC);
        foreach ($comptes as $key => $cmpt){
            $info = $cmpt;
            echo "<div class='mycomptes'>";
            foreach($info as $key2 => $info) {
                echo "<p>" . $key2." : ". $info . "</p>";
            }
            echo "</div><br>";
        }
        ?> 
        <form method="post">
            <input class='button' type="submit" value="Deconnexion" name="deconnexion" class="outbutton"> 
        </form>
        <footer class='footer'>
        <?php require_once __DIR__ . '/../src/templates/partials/footer.php';?>
        </footer>  
    </body>
</html>