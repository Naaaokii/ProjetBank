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
    foreach ($role as $key => $qui) {
        if ($qui == "admin" || $qui == "moderator") {
            $message = "right password and mail";
            echo "<script type='text/javascript'>alert('$message');</script>";
            $autregalere = $dbh->prepare('SELECT * FROM depots WHERE verif = 0');
            $autregalere->execute();
            $depots = $autregalere->fetchAll();
            echo "<tr><th>Id dépots</th><th>id compte</th><th>id monaie </th><th>montant</th><th>verifier?</th><tr></tr>";
            foreach ($depots as $key => $value) {
                $subkey = $value;
                echo "<tr>";
                foreach ($subkey as $key2 => $attri) {
                    echo "<td>" . $attri . "</td>";
                }
            }
        }else if($qui['role'] == "banned" ){
            header('location:register.php');
        }else if ($qui['role'] == "unverified" ){
            header("location:enattente.php");
        }
    }
}
if(isset($_POST['depot'])){
    if(isset($_POST['numberaccount'], $_POST['solde']) && !empty($_POST['numberaccount']) && !empty($_POST['solde'])){
        
        $numberAccount = $_POST['numberaccount'];
        $soldeDepot = $_POST['solde'];

        // Récupérer l'id de l'utilisateur connecté
        $mail = $_SESSION['email'];
        $req = $dbh->prepare('SELECT id FROM users WHERE email = :email');
        $req->execute(array('email' => $mail));
        $user = $req->fetch();
        $idUser = $user['id'];

        // Récupérer l'id_user par rapport au compte
        $sth = $dbh->prepare('SELECT id_cmpt, id_user, id_monaie FROM comptes WHERE numero = :numero0');
        $sth->execute(array('numero0' => $numberAccount));
        $user = $sth->fetch();
        $userId = $user['id_user'];
        $monaieId = $user['id_monaie'];
        $compteId = $user['id_cmpt'];

        // Si le numero de compte de l'expediteur est bien celui de la personne connecté
        if ($idUser == $userId) {

            $req = $dbh->prepare("INSERT INTO depots(id_compte, id_monaie, montant, verif, id_user)  VALUES (?,?,?,?,?)");
            $req->execute([$compteId, $monaieId, $soldeDepot, 'unverified', $idUser]);

            $soldeTotal = $soldeActuelle + $soldeDepot;

            $sth = $dbh->prepare("UPDATE comptes SET solde = :solde WHERE numero = :numero");
            $sth->execute(['solde' => $soldeTotal, 'numero' => $numberAccount]);
        } else {
            echo 'Numéro de compte invalide';
        }
    }
}

?>

<?php
    $page_title = 'DEPOTS';
    require_once __DIR__ . '/../src/templates/partials/html_head.php';
?>
    <body>
        <header>
            <?php
            require_once __DIR__ . '/../src/templates/partials/header.php';
            ?>
        </header>
        <h1 class='title'>DEPOTS</h1>
        <?php
        if(!isset($_SESSION['email'])){
            header("location:login.php");
        }else{
            $email = $_SESSION['email'];
            $sqladmin = $dbh->prepare('SELECT role FROM users WHERE email = :email');
            $sqladmin->execute(array("email" => $email));
            $role = $sqladmin->fetch(PDO::FETCH_ASSOC);
            if(!$role["role"]=="admin"|| !$role["role"]== "manager"){
                header("location:index.php");
            }
        }
        $email = $_SESSION['email'];
        $sqladmin = $dbh->prepare('SELECT role FROM users WHERE email = :email');
        $sqladmin->execute(array("email" => $email));
        $role = $sqladmin->fetch();

        if ($role['role'] == "admin" || $role['role'] == "moderator") {

            //$autregalere = $dbh->prepare('SELECT depots.id_depot, depots.id_compte, monnaies.nom, depots.montant FROM
            //depots INNER JOIN monnaies ON depots.id_monnaie = monnaies.id_Monnaies WHERE depots.verif = 0;');
            $autregalere = $dbh->prepare('SELECT id_depot, id_compte, id_monnaie, montant FROM depots WHERE verif = 0;');
            $autregalere->execute();
            $depots = $autregalere->fetchAll(PDO::FETCH_ASSOC);
            echo "<table id='tabdepots'>";
            echo "<div><tr><th>Id dépots</th><th>id compte</th><th>id monaie </th><th>montant</th><th>verifier?</th><tr></tr>";
            foreach ($depots as $key => $value) {
                $subkey = $value;
                echo "<tr>";
                foreach ($subkey as $key2 => $attri) {
                    echo "<td>" .$attri. "</td>";
                }
                echo "</tr>";
            }
        echo '</table>';
        }

        ?>
        <div class="createaccount">
            <h2 class='titlecreateaccount'>Faire un dépot</h2>
            <form method="post">
                <input class="numberaccount" type="number"  name="numberaccount"  id="numberaccount"  placeholder="Numéro du compte" required>
                <input class="solde" type="number"  name="solde"  id="solde"  placeholder="Solde" required>
                <input class='buttondaccount' type="submit" value="Déposer" name="depot" class="inpbutton">
            </form>
        </div>
        <footer class='footer'>
            <?php 
                require_once __DIR__ . '/../src/templates/partials/footer.php'; 
            ?>
        </footer>  
    </body>
</html>